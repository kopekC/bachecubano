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
use App\AdPromo;

use App\Mail\AdPublished;
use App\Notifications\AdPromotedTelegram;
use App\Notifications\AdPromotedTwitter;
use stdClass;

use App\User;
use Illuminate\Database\Eloquent\Builder;

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

        //Blow up all of this if not supercategory met requirements
        if (is_null($super_category) && $category != "search") {
            abort(404);
        }

        if ($sub_category != "") {
            $seo_data = ['title' => $sub_category->name, 'desc' => $sub_category->description];
        } elseif ($category == "search") {
            $seo_data = ['title' => "Buscando " . $request->input('s') . " en Bachecubano ", 'desc' => "Buscando anuncios con " . $request->input('s') . " en Bachecubano "];
        } else {
            $seo_data = ['title' => $super_category->name, 'desc' => $super_category->description];
        }

        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //post Per Page Custom configuration now as static method ok?
        $posts_per_page = AdController::post_per_page($request);

        //Category Condition if subcategory or Super Category
        //If Pass a single ID, its  asubcategory, i pass an array its a supercategory
        if (isset($sub_category->category_id)) {
            $ids = $sub_category->category_id;
        } elseif ($category == "search") {

            //Retrieve here all ids
            $all_cats = Cache::get('cached_categories');

            $super_category = new stdClass();
            $super_category->name = $seo_data['title'];
            $super_category->description = $seo_data['desc'];


            foreach ($all_cats as $subcategory)
                $ids[] = $subcategory->id;
        } else {
            $sub_categories = Category::where('parent_id', '=', $super_category->category_id)->select('id')->get();
            $ids = [];
            foreach ($sub_categories as $subcategory)
                $ids[] = $subcategory->id;
        }

        //Paginate all this
        $ads = AdController::getAds($request, $ids);

        return view('ads.index', compact('ads', 'super_category', 'sub_category', 'posts_per_page', 'request'));
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
        $regions = Cache::rememberForever('regions', function () {
            return AdRegion::all();
        });

        //Tell view that this is not an edit page
        $edit = false;

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

        return view('ads.add', compact('promoted_ads', 'regions', 'edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'category' => 'bail|required|numeric',
            'title' => 'bail|required',
            'description' => 'bail|required',
            'contact_name' => 'bail|required',
            'contact_email' => 'bail|required|email',
            'phone' => 'bail|required|numeric',
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
        $ad->region_id = $request->input('ad_region', "737586");
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

        //AutoRate this for a first time?
        if (Auth::check()) {
            Auth::getUser()->rate($ad, 5);
        }

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
        //Retrieve Ad with aditional data
        $ad = Cache::remember('ad-{$ad_id}', 60, function () use ($ad_id) {
            return Ad::with(['description', 'resources', 'category.description', 'category.parent.description', 'stats', 'owner', 'likes', 'likers'])->findOrFail($ad_id);
        });

        //Hit Visit to this Ad using increment method
        $stats = AdStats::findOrNew($ad->id);
        $stats->ad_id = $ad->id;
        $stats->increment('hits');
        $stats->save();

        //SEO Data
        $seo_data = [
            'title' => text_clean(Str::limit($ad->description->title, 60)),
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
                ->take(4)
                ->get();
        });

        //Rating Variables
        $averageRating = $ad->raters(User::class)->count() > 0 ? $ad->averageRating(User::class) : '5';
        $raters = $ad->raters(User::class)->count() > 0 ? $ad->raters(User::class)->count() : '1';

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
                    ->ratingValue($averageRating)
                    ->reviewCount($raters)
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

        return view('ads.show', compact('ad', 'promoted_ads', 'SchemaLD', 'averageRating', 'raters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ad $ad)
    {
        if (!Auth::check() || $ad->user_id != Auth::getUser()->id) {
            abort(403, 'Acción no autorizada');
        }

        //Pintar la misma pagina de ADD pero con los datos prellenos y un hidden que le indique que es edicion y no adicion?
        $edit = true;

        //get All regions of the system
        $regions = Cache::rememberForever('regions', function () {
            return AdRegion::all();
        });

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

        //Ad Images for prefill
        $ad_images = $ad->resources;

        return view('ads.add', compact('ad', 'promoted_ads', 'regions', 'edit', 'ad_images'));
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
        if (!Auth::check() || $ad->user_id != Auth::getUser()->id) {
            abort(403, 'Acción no autorizada');
        }

        //So Ad exists ok?
        //Just Modify it
        $request->validate([
            'category' => 'bail|required|numeric',
            'title' => 'bail|required|min:10|max:255',
            'description' => 'bail|min:10|required',
            'contact_name' => 'bail|required|min:3|max:255',
            'contact_email' => 'bail|required|email|min:5|max:255',
            'phone' => 'bail|required|numeric',
            'ad_region' => 'bail|required|numeric',
            "agree" => 'bail|required',
        ]);

        //Category data
        $category = Category::findOrFail($request->input('category'));

        //Now + 3 months
        $now = Carbon::now();
        $plus_3_months = $now->addMonths(3);

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
        $ad->region_id = $request->input('ad_region', "737586");
        $ad->update();

        //Description related table
        $description = AdDescription::where('ad_id', $ad->id)->first();

        //Check if sometime there is no Description yet
        if (is_null($description)) {
            $description = new AdDescription();
            $description->ad_id = $ad->id;
            $description->title = $request->input('title');
            $description->description = $request->input('description');
            $description->save();
        } else {
            $description->title = $request->input('title');
            $description->description = $request->input('description');
            $description->update();
        }

        return redirect(ad_url($ad));
    }

    /**
     * promote Page for Ad
     * //Get Ad info
     *  //Check User Balance
     *  //Show As preview and pricing options
     *  //Submit for with post value
     */
    public function promote_ad(Request $request, Ad $ad)
    {
        //SEO Data
        $seo_data = [
            'title' => "Promocionar anuncio: " . text_clean(Str::limit($ad->description->title, 30)),
            'desc' => "Promocionar anuncio: " . text_clean(Str::limit($ad->description->description, 130)),
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');


        //Retrieve from Cache, Not neccesary to retrieve again
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

        return view('ads.promote', compact('ad', 'promoted_ads'));
    }

    /**
     * POST request with the promotion ad
     */
    public function post_promote_ad(Request $request, Ad $ad)
    {
        //Request Validator
        $request->validate([
            'ad_id' => 'bail|required|numeric',
            'promotype' => 'bail|required|numeric'
        ]);

        //Promotions Plans Pricing
        $princing = [1 => 1, 2 => 5, 3 => 10, 4 => 20];

        //Get registered user
        $myself = Auth::getUser();

        //Check User balance
        $balance = $myself->wallet->credits;

        // Condition if Balance is not enough
        if ($balance >= $princing[$request->input('promotype')]) {

            //Find a better and pretty way to do this
            //$myself->wallet()->update(['credits' => $balance - $princing[$request->input('promotype')]]);     //Working solution
            $myself->wallet->deduce($princing[$request->input('promotype')]);             //Try to do this with the Wallet model

            //Now + 3 months
            $now = Carbon::now();
            $plus_1_month = $now->addMonths(1);

            //Then apply promotion plan
            //Search for a current promotion existence
            //FindOrCreate
            $promotion_ad = AdPromo::firstOrNew(['ad_id' => $ad->id]);
            $promotion_ad->promotype = $request->input('promotype');
            $promotion_ad->end_promo = $plus_1_month;                                     //Today plus 30 dias
            $promotion_ad->save();

            //Viralice ad
            //Promotion 1 -> Telegram
            if ($request->input('promotype') >= 1) {
                $ad->notify(new AdPromotedTelegram);
            }

            //Promotion 2 -> Telegram, Twitter
            if ($request->input('promotype') >= 2) {
                $ad->notify(new AdPromotedTwitter);
            }

            //Promotion 3 -> Telegram, Twitter, Facebook
            if ($request->input('promotype') >= 3) { }

            //Promotion 4 -> Telegram, Twitter, Facebook, Groups, PushNotifications
            if ($request->input('promotype') >= 4) { }


            //Redirect to ads listing with a flash messaje
            return redirect()->route('my_ads')->with('success', 'Felicidades! Ha promocionado su anuncio correctamente.');
        } else {
            //Redirecto to a non balance page or ads listing
            return redirect()->route('my_ads')->with('error', 'Lo sentimos, no posee saldo suficiente en su cuenta. Consulte con nuestros comerciales para acreditar su saldo');
        }
    }

    /**
     * general Search motor
     */
    public function search(Request $request)
    {
        //Global Search
        //HashTag Search
    }

    /**
     * Remove the specified resource from storage.
     * route(ad.destroy, ['ad' => $ad])
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ad $ad)
    {
        //This request came as xhr object ok?

        //Delete Ad assets, ad likes, adDescription, Ad promotions, favourites, etc

        //Check if came from a valid user
        $user = (new User())->getByToken($request->input('api_token'));

        if (!is_null($user) && $ad->user_id == $user->id) {

            //proceed, the user owns the ad and cascade the deletion
            $ad->delete();

            return response()->json(['message' => 'Ad deleted ' . $ad->id, 'status' => 200], 200);
        } else {
            echo "Wrong data, check again";
        }
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

    /**
     * Static Get Ads for API and Web Controller
     * $category_ids could be an ID or ID array, based on the subcategory or parent category
     */
    public static function getAds($request, $category_ids = null)
    {
        //Beguin Query
        $query = Ad::query();

        //Select All elements
        $query->select('ads.*', 'ad_promos.promotype');

        //Category Condition if subcategory or Super Category
        //If Parent this is arrays
        if (is_array($category_ids)) {
            $query->whereIn('category_id', $category_ids);
        } elseif (isset($category_ids)) {
            $query->where('category_id', $category_ids);
        }

        //With associated elements
        $query->with(['resources', 'category.description', 'category.parent.description']);

        //Join for a correct ordering?
        $query->leftjoin('ad_descriptions', 'ads.id', '=', 'ad_descriptions.ad_id');
        $query->leftjoin('ad_promos', 'ads.id', '=', 'ad_promos.ad_id');

        //Minimal Price
        if ($request->has('min_price') && is_numeric($request->input('min_price'))) {
            $query->when($request->input('min_price') >= 0, function ($q) use ($request) {
                return $q->where('price', '>=', $request->input('min_price'));
            });
        }

        //Maximum Price
        if ($request->has('max_price') && is_numeric($request->input('max_price'))) {
            $query->when($request->input('max_price') >= 0, function ($q) use ($request) {
                return $q->where('price', '<=', $request->input('max_price'));
            });
        }

        //Search Query With only Photos ads
        if ($request->has('only_photos')) {
            $query->when($request->input('only_photos') == 1, function ($q) {
                return $q->whereHas('resources');
            });
        }

        //hashTag Search
        if ($request->has('ht')) {
            $query->when($request->input('ht') != "", function ($q) use ($request) {
                return $q->where('body', 'LIKE', "%#{$request->input('ht', "#bache")}%");
            });
        }

        //Search terms
        if ($request->has('s') && $request->input('s') != "") {
            $query->when(strlen($request->input('s')) >= 2, function ($q) use ($request) {

                /* Encapsulate this into (query) */
                $q->where(function (Builder $query) use ($request) {
                    return $query->where('ad_descriptions.description', 'LIKE', "%{$request->input('s')}%")->orWhere('ad_descriptions.title', 'LIKE', "%{$request->input('s')}%");
                });
                
                return $q;
            });
        }

        //Order By PromoType and later as updated time
        $query->orderBy('ad_promos.promotype', 'desc');
        $query->latest('updated_at');

        //Activated parameters
        $query->where('active', 1);
        $query->where('enabled', 1);

        //Paginate all this
        $ads = $query->paginate(AdController::post_per_page($request));

        return $ads;
    }
}
