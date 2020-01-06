<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

use App\AdResource;
use App\User;

class ImageController extends Controller
{

    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('images');
    }

    //Testing Routes
    public function index(Request $request)
    {
        dd($request);
    }

    //Incoming Transacction
    public function save(Request $request)
    {
        //Photos Contains all fotos
        $photos = $request->file('photo');

        //Create Folder If dont exists
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        //Iterate on every photos?
        for ($i = 0; $i < count($photos); $i++) {

            $photo = $photos[$i];

            $photo_upload = new AdResource();                   //[id, ad_id, extension, path]
            $photo_upload->ad_id = 0;
            $photo_upload->extension = $photo->getClientOriginalExtension();
            $photo_upload->path = 'images' . DIRECTORY_SEPARATOR . rand(0, 9999) . DIRECTORY_SEPARATOR;
            $photo_upload->save();

            //Create Folder If dont exists
            if (!is_dir($photo_upload->path)) {
                mkdir($photo_upload->path, 0777);
            }

            //Name is the actual ID of AdResource object
            $name = $photo_upload->id;

            $original_name = $name . '_original.' . $photo->getClientOriginalExtension();
            $photo_480 = $name . '.' . $photo->getClientOriginalExtension();
            $photo_preview = $name . '_preview.' . $photo->getClientOriginalExtension();
            $photo_thumbnail = $name . '_thumbnail.' . $photo->getClientOriginalExtension();

            //There are four photos xxx (480), xxx_original (orig), xxx_preview (340), xxx_thumbnail (200)

            //Image manipulation thumbnail
            Image::make($photo)
                ->resize(200, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($photo_upload->path . DIRECTORY_SEPARATOR . $photo_thumbnail);

            //Image manipulation preview
            Image::make($photo)
                ->resize(340, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($photo_upload->path . DIRECTORY_SEPARATOR . $photo_preview);

            //Image manipulation thumbnail
            Image::make($photo)
                ->resize(480, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($photo_upload->path . DIRECTORY_SEPARATOR . $photo_480);

            /* WaterMark Ads at Social Media Share
            Image::make($photo)
                ->insert(public_path('watermark.png'), 'bottom-right', 10, 10)
                ->save();
                */

            //Original Move photo
            $photo->move($photo_upload->path, $original_name);
        }

        return Response::json(['message' => 'Image saved Successfully', 'imageID' => $photo_upload->id, 'status' => 200], 200);
    }

    /**
     * AJAX Destroy Image
     */
    public function destroy(Request $request)
    {
        $filename = $request->id;
        $uploaded_image = Upload::where('original_name', basename($filename))->first();

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . DIRECTORY_SEPARATOR . $uploaded_image->filename;
        $resized_file = $this->photos_path . DIRECTORY_SEPARATOR . $uploaded_image->resized_name;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (file_exists($resized_file)) {
            unlink($resized_file);
        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }

    /**
     * Save Profile Picture into database
     */
    public function save_profile_image(Request $request)
    {
        //Photos Contains all fotos
        $photo = $request->file('photo');

        //Myself
        $user = (new User())->getByToken($request->input('api_token'));

        //Create Folder If dont exists
        if (!is_dir($this->photos_path . DIRECTORY_SEPARATOR . "uploads")) {
            mkdir($this->photos_path . DIRECTORY_SEPARATOR . "uploads", 0777);
        }

        //Create Folder If dont exists
        if (!is_dir($this->photos_path . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $user->id)) {
            mkdir($this->photos_path . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $user->id, 0777);
        }

        //name of the uploaded picture
        $photo_name = "profile" . rand(0, 9999) . "." . $photo->getClientOriginalExtension();

        //Image manipulation thumbnail
        Image::make($photo)
            ->fit(240)                                                      //Get the most important data from center of the image
            ->save($this->photos_path . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $user->id . DIRECTORY_SEPARATOR . $photo_name);

        //Update User Profile picture name
        $user->profile_picture = $photo_name;
        $user->update();

        return Response::json(['message' => 'Profile picture updated', 'status' => 200], 200);
    }
}
