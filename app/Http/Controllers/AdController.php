<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Facades\URL;

use SEOMeta;
use OpenGraph;
use Twitter;

use App\AdDescription;
use App\AdStats;
use App\AdRegion;
use App\CategoryDescription;
use App\Category;
use App\Ad;

use App\Mail\AdPublished;

use stdClass;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category, $subcategory = "")
    {
        //Get Super and SubCategory
        $super_category = CategoryDescription::where('slug', $category)->first();
        $sub_category =  CategoryDescription::where('slug', $subcategory)->first();

        if ($sub_category != "") {
            $seo_data = [
                'title' => $sub_category->name,
                'desc' => $sub_category->description,
            ];
        } else {
            $seo_data = [
                'title' => $super_category->name,
                'desc' => $super_category->description,
            ];
        }
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Parametrice all Input elements and pass to corresponding method where
        //Getted from Input GET data

        //post Per Page Custom configuration now as static method ok?
        $posts_per_page = AdController::post_per_page($request);

        $query = Ad::query();

        //Select All elements
        $query->select('ads.*', 'ad_promos.promotype');

        //Category Condition if subcategory or Super Category
        if (isset($sub_category->category_id)) {
            $query->where('category_id', $sub_category->category_id);
        } else {
            $sub_categories = Category::where('parent_id', '=', $super_category->category_id)->select('id')->get();
            $query->whereIn('category_id', $sub_categories);
        }

        //With associated elements
        $query->with(['description', 'resources', 'category.description', 'category.parent.description']);

        //Join for a correct ordering?
        $query->leftjoin('ad_promos', 'ads.id', '=', 'ad_promos.ad_id');

        //Minimal Price
        if (null !== $request->input('min_price')) {
            $query->when($request->input('min_price') >= 0, function ($q) {
                return $q->where('price', '>=', $request->input('min_price', 0));
            });
        }

        //Maximum Price
        if (null !== $request->input('max_price')) {
            $query->when($request->input('max_price') >= 0, function ($q) {
                return $q->where('price', '<=', $request->input('max_price', 0));
            });
        }

        //Search Query With on;y Photos ads
        if (null !== $request->input('only_photos')) {
            $query->when($request->input('only_photos') == 1, function ($q) {
                return $q->whereHas('resources');
            });
        }

        //Order By PromoType and later as updated time
        $query->orderBy('ad_promos.promotype', 'desc');
        $query->latest();

        //Activated parameters
        $query->where('active', 1);
        $query->where('enabled', 1);

        //Paginate all this
        $ads = $query->paginate($posts_per_page);

        return view('ads.index', compact('ads', 'super_category', 'sub_category', 'posts_per_page'));
    }

    /**
     * Show the form for creating a new Ad.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Publicar anuncio gratis",
            'desc' => "Promociona tu producto, negocio o servicio en nuestra web GRATIS",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //get All regions of the system
        $regions = AdRegion::all();

        //Featured Listing, Diamond and Gold Random
        $promoted_ads = Cache::remember('promoted_ads', 60, function () {
            return Ad::where('active', 1)
                ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
                ->whereHas('promo', function ($query) {
                    $query->where('promotype', '>=', 3);
                })
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        return view('ads.add', compact('promoted_ads', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'bail|required|numeric',
            'title' => 'bail|required|min:10|max:255',
            'description' => 'bail|min:10|required',
            'contact_name' => 'bail|required|min:3|max:255',
            'contact_email' => 'bail|required|email|min:5|max:255',
            'phone' => 'bail|required|numeric|min:8|max:16',
            'ad_region' => 'bail|required|numeric',
            "agree" => 'bail|required',
        ]);

        //Category data
        $category = Category::findOrFail($request->input('category'));

        //Now + 3 months
        $now = Carbon::now();
        $plus_3_months = $now->addMonths(3);

        //Ad Basic Elements elements
        $ad = new Ad;

        //Basic Table
        Auth::check() ? $ad->user_id = Auth::id() : $ad->user_id = 0;
        $ad->category_id = $category->id;
        $ad->price = $request->input('price', 0);
        $ad->contact_name = $request->input('contact_name');
        $ad->contact_email = $request->input('contact_email');
        $ad->ip = $request->ip();
        $ad->premium = 0;
        $ad->enabled = 1;
        $ad->active = 1;
        $ad->spam = 0;
        $ad->secret = Str::random(20);
        $ad->expiration = $plus_3_months->format("Y-m-d H:i:s");
        $ad->phone = $request->input('phone', "");
        $ad->save();

        //Images Logic for AdResources
        if (null !== $request->input('imageID')) {
            //Update every row with the actual ad_id
            //UPDATE ad_resources SET ad_id = xx WHERE id = imageID.index
            foreach ($request->input('imageID') as $adResourdeId) {
                DB::table('ad_resources')->where('id', $adResourdeId)->update(['ad_id' => $ad->id]);
            }
        }

        //Description related table
        $description = new AdDescription;
        $description->ad_id = $ad->id;
        $description->title = $request->input('title');
        $description->description = $request->input('description');
        $description->save();

        //Retrieve Ad Again
        $ad = Ad::with(['description', 'category.description', 'category.parent.description'])->findOrFail($ad->id);

        //Send Notification Email to the User
        //If is guest, always send this email, if it's registered user check for user settings and verify email.published = true 👌
        if (Auth::check()) {
            // The user is logged in... So check if send notifications email.add it's true
            AdController::send_published_ad_email($ad, Auth::user());
        } else {
            //Send Email, it's a Guest user
            $user = new stdClass();
            $user->name = $ad->contact_name;
            $user->email = $ad->contact_email;
            $user->phone = $ad->phone;
            AdController::send_published_ad_email($ad, $user);
        }

        return redirect(ad_url($ad));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $category, $subcategory, $ad_title, $ad_id)
    {
        //Retrieve Ad
        $ad = Cache::remember('ad-{$ad_id}', 5, function () use ($ad_id) {
            return Ad::with(['description', 'resources', 'category.description', 'category.parent.description', 'stats', 'owner'])->findOrFail($ad_id);
        });

        //Hit Visit to this Ad using increment method
        $stats = AdStats::findOrNew($ad->id);       //No puedes crearlo asi, hay que hacer un if
        $stats->ad_id = $ad->id;
        $stats->increment('hits');                  //Default value 1
        $stats->save();

        //SEO Data
        $seo_data = [
            'title' => Str::limit($ad->description->title, 60),
            'desc' => text_clean(Str::limit($ad->description->description, 160)),
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Iterate every image for OpenGrap and Owl Carousell
        if (count($ad->resources) >= 1) {
            foreach ($ad->resources as $resource) {
                OpenGraph::addImage(ad_image_url($resource));
            }
        } else {
            OpenGraph::addImage(ad_first_image($ad));
        }

        //Retrieve from Cache, Not neccesary to retrieve again
        $promoted_ads = Cache::remember('promoted_ads', 60, function () {
            return Ad::where('active', 1)
                ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
                ->whereHas('promo', function ($query) {
                    $query->where('promotype', '>=', 3);
                })
                ->inRandomOrder()
                ->take(8)
                ->get();
        });

        //Schema
        $SchemaLD = Schema::Product()
            ->name($seo_data['title'])
            ->image(ad_first_image($ad))
            ->description($seo_data['desc'])
            ->mpn($ad->id)
            //->brand(Schema::Thing()->name("name"))
            //->logo()
            ->aggregateRating(
                Schema::aggregateRating()
                    ->ratingValue('5')
                    ->reviewCount('1')
            )
            ->offers(
                Schema::Offer()
                    ->priceCurrency("CUC")
                    ->price($ad->price)
                    ->priceValidUntil($ad->expiration)
                    ->itemCondition("http://schema.org/NewCondition")
                    ->availability("http://schema.org/InStock")
                    ->url(URL::current())
                    ->seller(
                        Schema::Organization()
                            ->name($ad->contact_name)
                    )
            );

        return view('ads.show', compact('ad', 'promoted_ads', 'SchemaLD'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ad $ad)
    {
        //Well, here paint the ad therefore isn't
        //Pintar la misma pagina de ADD pero con los datos prellenos y un hidden que le indique que es edicion y no adicion?
        dd($ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ad $ad)
    {
        //This request came as xhr object ok?

    }

    /**
     * Get Post per Page value
     */
    public static function post_per_page($request)
    {
        /**
         * It means – let’s try to get posts_per_page from GET request, if it’s not there, then let’s default to the data in the Cookie.
         */
        $cookie_value = Cookie::get('posts_per_page');
        $posts_per_page = $request->get('posts_per_page', $cookie_value);

        /**
         * But what if there’s no Cookie? That’s the second block:
         * We save possible pagination values, and a default value in config file – in my case it’s config/constants.php:
         */
        $options = config('constants.posts_per_page_options');
        if (!$posts_per_page || !in_array($posts_per_page, $options)) {
            $posts_per_page = config('constants.posts_per_page_default');
        }

        /**
         * We save possible pagination values, and a default value in config file – in my case it’s config/constants.php
         * Finally, last line is just saving that value into the Cookie again, for the future requests.
         */

        Cookie::queue('posts_per_page', $posts_per_page);

        return $posts_per_page;
    }

    /**
     * Send an Email with the published Email Data ans a some welcome user
     * Mailable: AdPublished ($ad, $user_data)
     */
    public static function send_published_ad_email($ad, $user_data)
    {
        /**
         * Sometimes you may wish to capture the HTML content of a mailable without sending it. To accomplish this, you may call the `render` method of the mailable.
         * return (new App\Mail\InvoicePaid($invoice))->render();
         */
        return Mail::to($user_data->email)->send(new AdPublished($ad, $user_data));
    }
}
