<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Spatie\Sitemap\Sitemap;
use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Ad;
use App\Post;

use Spatie\Sitemap\SitemapIndex;
use App\AdResource;

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
        $this->static();
        $this->categories();
        $this->ads();
        $this->news();
        $this->images();

        SitemapIndex::create()
            ->add(public_path('static.xml'))
            ->add(public_path('categories.xml'))
            ->add(public_path('ads.xml'))
            ->add(public_path('news.xml'))
            ->add(public_path('images.xml'))
            //->add(public_path('promoted.xml'))
            //->add(public_path('stores.xml'))
            //->add(public_path('top-searches.xml'))
            ->writeToFile($this->sitemapPath);
    }

    //Sitemap for Static Pages
    public function static()
    {
        $sitemap = Sitemap::create();
        $sitemap->add(route('welcome'));
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
        $categories = Cache::remember('cached_categories', 60 * 24 * 7, function () {
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
        $ads = Cache::remember('cached_1000_ads', 30, function () {
            return Ad::with(['description', 'category', 'resources'])->limit(1000)->latest()->get();
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
        $latest_blog_post = Cache::remember('latest_blog_post_10', 60 * 12, function () {
            return Post::latest()->limit(10)->get();
        });
        foreach ($latest_blog_post as $blog_post) {
            $sitemap->add(route('blog_post', ['entry_slug' => $blog_post->slug]));
        }

        $sitemap->writeToFile(public_path('news.xml'));
    }

    //Images Sitemap
    public function images()
    {
        $sitemap = Sitemap::create();

        //Images Cache Location
        $latest_images = Cache::remember('latest_images_500', 60 * 12, function () {
            return AdResource::latest()->limit(500)->get();
        });
        foreach ($latest_images as $image) {
            $sitemap->add(config('app.img_url') . $image->path . $image->id . "." . $image->extension);
        }

        $sitemap->writeToFile(public_path('images.xml'));
    }
}
