<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ad;
use App\Http\Controllers\Api\PushController;
use App\Mail\Contact;
use App\Notifications\AdPromotedFacebook;
use SEOMeta;
use OpenGraph;
use Twitter;
use Spatie\SchemaOrg\Schema;

use Illuminate\Support\Facades\Cache;
use App\Post;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $province_slug = "")
    {
        //SEO Data
        $seo_data = [
            'title' => 'Computadoras, celulares, electrodomésticos, casas y carros en Cuba',
            'desc' => 'Web de negocios, tiendas y clasificados en Cuba. Especialidad en computadoras, celulares, accesorios, electrodomésticos, casas, carros y compras online.',
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addImage(asset('android-chrome-512x512.png'));
        OpenGraph::addProperty('type', 'website');
        Twitter::setTitle($seo_data['title']);

        //Remember this result a 1 hour 👇
        $promoted_ads = Cache::remember('promoted_ads', 60, function () {
            return Ad::where('active', 1)
                ->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']) //<- Nested Load Category, and Parent Category
                ->whereHas('promo', function ($query) {
                    $query->where('promotype', '>=', 3);
                })
                ->inRandomOrder()
                ->take(6)
                ->get();
        });

        //testimonial
        //Try to fetch from facebook isn't with JS

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

        //Hide here the Google Ads
        $show_ads = false;

        //Analize the variable submit, could be better
        return view('welcome', compact('promoted_ads', 'SchemaLD', 'show_ads'));
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

        //Search Bar
        $search_bar = true;

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

        return view('contact', compact('search_bar'));
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
            'g-recaptcha-response' => 'recaptcha',              //Recaptcha Google Check
        ]);

        $data = $request->only('name', 'email', 'subject', 'message');

        //Notify Admin of this registration event
        $admin = "ecruz@bachecubano.com";
        Mail::to($admin)->send(new Contact($data));

        return redirect()->route('contact')->with('success', 'Gracias! En breve nos pondremos en contacto');
    }

    /**
     * Terms Page
     */
    public function terms()
    {
        //SEO Data
        $seo_data = [
            'title' => 'Términos y condiciones de uso',
            'desc' => 'Bachecubano se reserva el derecho a tomar medidas con sus usuarios o anuncios basado en la violación de las siguientes normas',
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addImage(asset('android-chrome-512x512.png'));
        Twitter::setTitle($seo_data['title']);

        //Search Bar
        $search_bar = true;

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

        return view('terms', compact('search_bar'));
    }

    /**
     * Display basic CSS files in one
     */
    public function bachecubano_css()
    {
        // First of all send css header
        header("Content-type: text/css");

        // Array of css files
        $css = [
            'css/bs.css',
            'css/slicknav.min.css',
            'css/main2.css',
            'css/responsive.css',
            'css/animate.css',
            'css/LineIcons.min.css'
        ];

        // Prevent a notice
        $css_content = '';

        // Loop the css Array
        foreach ($css as $css_file) {
            // Load the content of the css file 
            $css_content .= file_get_contents($css_file);
        }

        // print the css content
        echo $css_content;
    }

    public function bachecubano_js()
    {
        // First of all send css header
        header("Content-type: application/javascript");

        // Array of css files
        $js = [
            'js/jquery-3.3.1.min.js',
            'js/lazysizes.min.js',
            'js/popper.min.js',
            'js/bs.js',
            'js/jquery.slicknav.min.js',
            'js/wow.js',
            'js/main4.js',
            //'js/analytics.js'                     Removed analytics
        ];

        // Prevent a notice
        $js_content = '';

        // Loop the css Array
        foreach ($js as $js_file) {
            // Load the content of the css file 
            $js_content .= file_get_contents($js_file) . "\n";
        }

        // print the css content
        echo $js_content;
    }
}
