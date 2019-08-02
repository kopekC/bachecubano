<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ad;
use SEOMeta;
use OpenGraph;
use Twitter;
use Spatie\SchemaOrg\Schema;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //SEO Data
        $seo_data = [
            'title' => 'Computadoras, celulares, electrodométicos, casas y carros en Cuba',
            'desc' => 'Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas, carros y compras online.',
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addImage(asset('android-chrome-512x512.png'));
        Twitter::setTitle($seo_data['title']);

        //Latest Ads (With Photo only)
        $latest_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description'])
            ->has('resources')  //Has Pictures...
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        //Featured Listing, Diamond and Gold Random
        $promoted_ads = Ad::where('active', 1)
            ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 3);
            })
            ->inRandomOrder()
            ->take(8)
            ->get();

        //testimonial
        //Try to fetch from facebook isn't with JS

        //blog posts        
        //First Make the blog 🤣

        //Schema
        $SchemaLD = Schema::WholesaleStore()
            ->name('Bachecubano')
            ->url('https://www.bachecubano.com')
            ->logo('https://www.bachecubano.com/android-chrome-512x512.png')
            ->priceRange("$$")
            ->image('https://www.bachecubano.com/android-chrome-512x512.png')
            ->description($seo_data['desc'])
            ->address(
                Schema::PostalAddress()
                    ->streetAddress('Calle 35 #1477 entre 26 y 28, Nuevo Vedado, La habana, Cuba')
                    ->addressLocality('Plaza de la Revolución')
                    ->addressRegion('La Habana')
                    ->postalCode('10400')
                    ->addressCountry('Cuba')
            )
            ->geo(
                Schema::GeoCoordinates()
                    ->latitude("23.117155")
                    ->longitude("-82.402568")
            )
            ->hasMap("https://goo.gl/maps/y4L3FwYSWvAhmH7s7")
            ->openingHours("Mo 09:00-21:00 Tu 09:00-21:00 We 09:00-21:00 Th 09:00-21:00 Fr 09:00-21:00 Sa 09:00-21:00 Su 09:00-21:00")
            ->aggregateRating(
                Schema::aggregateRating()
                    ->ratingValue('5')
                    ->reviewCount('121')
            )
            ->brand('Bachecubano')
            ->telephone("+5355149081")
            ->employee('3')
            ->contactPoint(
                Schema::contactPoint()
                    ->areaServed('Cuba')
                    ->telephone("+5355149081")
                    ->contactType("sales")
                    ->email('contacto@bachecubano.com')
            );

        //Analize the variable submit, could be better
        return view('welcome', compact('latest_ads', 'promoted_ads', 'SchemaLD'));
    }

    /**
     * Contact
     */
    public function contact(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => 'Contactar con el equipo',
            'desc' => 'Contactar con nuestro equipo y tramitar algún pedido, conocer promociones o reportar algún problema a Bachecubano',
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addImage(asset('android-chrome-512x512.png'));
        Twitter::setTitle($seo_data['title']);

        //Schema
        $SchemaLD = Schema::WholesaleStore()
            ->name('Bachecubano')
            ->url('https://www.bachecubano.com')
            ->logo('https://www.bachecubano.com/android-chrome-512x512.png')
            ->priceRange("$$")
            ->image('https://www.bachecubano.com/android-chrome-512x512.png')
            ->description($seo_data['desc'])
            ->address(
                Schema::PostalAddress()
                    ->streetAddress('Calle 35 #1477 entre 26 y 28, Nuevo Vedado, La habana, Cuba')
                    ->addressLocality('Plaza de la Revolución')
                    ->addressRegion('La Habana')
                    ->postalCode('10400')
                    ->addressCountry('Cuba')
            )
            ->geo(
                Schema::GeoCoordinates()
                    ->latitude("23.117155")
                    ->longitude("-82.402568")
            )
            ->hasMap("https://goo.gl/maps/y4L3FwYSWvAhmH7s7")
            ->openingHours("Mo 09:00-21:00 Tu 09:00-21:00 We 09:00-21:00 Th 09:00-21:00 Fr 09:00-21:00 Sa 09:00-21:00 Su 09:00-21:00")
            ->aggregateRating(
                Schema::aggregateRating()
                    ->ratingValue('5')
                    ->reviewCount('121')
            )
            ->brand('Bachecubano')
            ->telephone("+5355149081")
            ->employee('3')
            ->contactPoint(
                Schema::contactPoint()
                    ->areaServed('Cuba')
                    ->telephone("+5355149081")
                    ->contactType("sales")
                    ->email('contacto@bachecubano.com')
            );

        return view('contact');
    }

    /**
     * Contact Post Procedure
     */
    public function contact_submit(Request $request)
    {
        //Validate Incoming Data & create card
        $validatedData = $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required',
            'subject' => 'bail|required',
            'message' => 'bail|required',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        $data = $request->only('name', 'last_name', 'email', 'phone', 'contact-text');

        //Notify Admin of this registration event
        $admin = "ecruz@bachecubano.com";
        Mail::to($admin)->send(new ContactForm($data));

        return redirect()->route('contact')->with('success', 'Gracias! En breve nos pondremos en contacto');
    }
}
