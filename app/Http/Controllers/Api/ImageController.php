<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Photo;

use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{

    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/images4');
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

            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

            //Image manipulation
            Image::make($photo)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->photos_path . '/' . $resize_name);

            $photo->move($this->photos_path, $save_name);

            //$upload = new Upload();
            //$upload->filename = $save_name;
            //$upload->resized_name = $resize_name;
            //$upload->original_name = basename($photo->getClientOriginalName());
            //$upload->save();
        }
        return Response::json(['message' => 'Image saved Successfully'], 200);
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

        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;

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
}
