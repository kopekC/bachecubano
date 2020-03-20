<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Spatie\Sitemap\Sitemap;
use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Ad;
use App\Post;

use Spatie\Sitemap\SitemapIndex;
use App\AdResource;

use App\AdLocation;

error_reporting(E_ALL);
set_time_limit(0);

class SitemapController extends Controller
{
    private $sitemapPath;

    public function __construct()
    {
        $this->sitemapPath = public_path('sitemap.xml');
    }

    //index of Sitemaps, include here images SiteMap
    public function sitemap_index()
    {
        //generate every sitemap as method here, the create the sitemap container
        //Static Pages
        echo "Generating Static Pages";
        $this->static();

        echo "Generating Provinces";
        $this->provinces();

        //All Category Pages
        echo "Generating Category Pages";
        $this->categories();

        echo "Generating News Pages";
        $this->news();

        echo "Generating Images Pages";
        $this->images();

        echo "Generating Ads Pages";
        $this->ads();

        SitemapIndex::create()
            ->add(config('app.url') . 'provinces.xml')
            ->add(config('app.url') . 'static.xml')
            ->add(config('app.url') . 'categories.xml')
            ->add(config('app.url') . 'news.xml')
            ->add(config('app.url') . 'images.xml')
            ->add(config('app.url') . 'ads.xml')
            //->add(public_path('promoted.xml'))
            //->add(public_path('stores.xml'))
            //->add(public_path('top-searches.xml'))
            ->writeToFile($this->sitemapPath);
    }

    //Sitemap for Static Pages
    public function static()
    {
        $sitemap = Sitemap::create();
        $sitemap->add(route('welcome', ['province_slug' => 'www']));
        $sitemap->add(route('add'));
        $sitemap->add(route('contact'));
        $sitemap->add(route('blog.index'));
        $sitemap->writeToFile(public_path('static.xml'));
    }

    //Sitemap for Categories Pages
    public function categories()
    {
        $sitemap = Sitemap::create();

        //Global Cached Categories Data Cache one week
        $categories = Cache::rememberForever('cached_categories', function () {
            return Category::with('description')->get();
        });

        //Iterate Over cateogories
        $parent_categories = [];
        $category_formatted = [];
        foreach ($categories as $cat) {
            if (is_null($cat->parent_id)) {
                $parent_categories[] = $cat;
                $sitemap->add(route('super_category_index', ['category' => $cat->description->slug]));
            } else {
                $category_formatted[$cat->parent_id][] = $cat->description;
                $sitemap->add(route('category_index', ['category' => $cat->parent->description->slug, 'subcategory' => $cat->description->slug]));
            }
        }

        $sitemap->writeToFile(public_path('categories.xml'));
    }

    //1000 Ads location
    public function ads()
    {
        $sitemap = Sitemap::create();

        //Latest Ads (How Many?? 1000??)
        $ads = Cache::remember('cached_10000_ads', 600, function () {
            return Ad::with(['description', 'category', 'resources'])->limit(10000)->latest()->get();
        });
        foreach ($ads as $ad) {
            $sitemap->add(ad_url($ad));
        }

        $sitemap->writeToFile(public_path('ads.xml'));
    }

    //Website News SiteMap
    public function news()
    {
        $sitemap = Sitemap::create();

        //News Cache Entries
        $latest_blog_post = Cache::remember('latest_blog_post_100', 60 * 12, function () {
            return Post::where('enabled', 1)->with('owner', 'category')->latest()->limit(100)->get();
        });

        //Iterate over every latest blog post
        foreach ($latest_blog_post as $blog_post) {
            $sitemap->add(post_url($blog_post));
        }

        $sitemap->writeToFile(public_path('news.xml'));
    }

    //Images Sitemap
    public function images()
    {
        $sitemap = Sitemap::create();

        //Images Cache Location
        $latest_images = Cache::remember('latest_images_1000', 60 * 12, function () {
            return AdResource::orderBy('id', 'desc')->limit(1000)->get();
        });
        foreach ($latest_images as $image) {
            $sitemap->add(config('app.img_url') . $image->path . $image->id . "." . $image->extension);
        }

        $sitemap->writeToFile(public_path('images.xml'));
    }

    //Provinces Sitemap
    public function provinces()
    {
        $sitemap = Sitemap::create();

        //Global Cached Locations Data Cache forever
        $locations = Cache::rememberForever('cached_locations', function () {
            return AdLocation::get();
        });

        //Foreach Location as subdomain
        foreach ($locations as $location) {
            $sitemap->add("https://" . $location->slug . "bachecubano.com");
        }

        $sitemap->writeToFile(public_path('provinces.xml'));
    }
}
