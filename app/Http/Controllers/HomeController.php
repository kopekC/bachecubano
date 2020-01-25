<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SEOMeta;
use OpenGraph;
use Twitter;

use Illuminate\Support\Facades\Auth;
use App\Ad;
use App\Mail\TransferReceived;
use Illuminate\Support\Str;

use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Only autenticated users can use this controller
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Panel Principal en Bachecubano",
            'desc' => "Análisis de estadísticas y gestión de mi perfil en Bachecubano",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');

        //Create the initial token for first time use for old users
        if (is_null(Auth::user()->api_token)) {
            $token = Str::random(60);
            Auth::user()->forceFill(['api_token' => $token])->save();
        }

        //Total active ads
        $total_active_ads = Auth::user()->ads->count();

        //Total Promoted Ads
        $total_promoted_ads = Ad::where('active', 1)
            ->where('user_id', Auth::user()->id)
            ->whereHas('promo', function ($query) {
                $query->where('promotype', '>=', 1);
            })
            ->count();

        //Most Popular Ads
        $popular_ads = Ad::where('user_id', Auth::user()->id)
            ->with(['description', 'resources', 'category.description', 'category.parent.description']) //<- Nested Load Category, and Parent Category
            ->join('ad_stats', 'ads.id', '=', 'ad_stats.ad_id')
            ->orderBy('ad_stats.hits', 'desc')
            ->take(10)
            ->get();

        $section_name = "Mi Panel de Anuncios";

        return view('user.home', compact('section_name', 'total_active_ads', 'total_promoted_ads', 'popular_ads'));
    }

    /** 
     * User Ads
     * Here:
     * paginate
     * Order By
     * Group By
     */
    public function ads(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Mis anuncios en Bachecubano",
            'desc' => "Análisis de estadísticas y gestión de mi perfil en Bachecubano",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');
        $section_name = "Mis Anuncios";

        //Total active ads
        $total_active_ads = Auth::user()->ads->count();

        //post Per Page Custom configuration
        $posts_per_page = 144;

        //Customize pagination
        //You may append to the query string of pagination links using the appends method. For example, to append sort=votes to each pagination link, you should make the following call to appends:
        //{{ $users->appends(['sort' => 'votes'])->links() }}

        $query = Ad::query();

        $query->where('user_id', Auth::user()->id);
        $query->with(['description', 'resources', 'category.description', 'category.parent.description', 'promo']);

        //Category Filtering for a Better Filtering
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        //Filter only promoted ads with the whereHas method
        if ($request->has('promoted')) {
            $query->when($request->input('promoted') == 1, function ($q) {
                return $q->whereHas('promo');
            });
        }

        //Filter only active ads
        if ($request->has('active') && $request->input('active') == 1) {
            $query->where('active', 1);
        }

        //Filter only inactive ads
        if ($request->has('inactive') && $request->input('inactive') == 1) {
            $query->where('active', 0);
        }

        //Order latest Update
        $query->latest();

        //Paginate for every ads
        $my_ads = $query->paginate($posts_per_page);

        return view('user.ads', compact('request', 'section_name', 'total_active_ads', 'my_ads'));
    }

    /**
     * user Settings
     */
    public function settings(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Configuración de mi cuenta",
            'desc' => "Configurar las preferencias generales e informacion de usuario en la web",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');
        $section_name = "Configuración de mi cuenta";

        $user = Auth::getUser();

        return view('user.settings', compact('section_name', 'user'));
    }

    /**
     * Favorites or liked ads
     */
    public function favourite(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Mis anuncios favoritos",
            'desc' => "Ver todos los anuncios a los que le has dado \"Me Gusta\"",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');
        $section_name = "Mis anuncios favoritos";

        $user = Auth::getUser();

        //Likes
        $my_likes = $user->likes()->with('likable')->paginate(20);

        return view('user.likes', compact('section_name', 'user', 'my_likes'));
    }

    /**
     * Delete this account
     */
    public function delete_account(Request $request)
    {
        $me = Auth::getUser();

        //elete account
        $me->delete();
        //Delete Ads
        //Delete Likes
        //Delete email subscriptions
        //Delete all contents

        //close session
        Session::flush();
        return redirect()->route('welcome');
    }

    /**
     * Update User Data
     */
    public function update_user(Request $request)
    {
        //Validate incoming data
        $request->validate([
            'name' => 'bail|required',
            'phone' => 'bail|required|numeric',               //5355149081
        ]);

        //Save incoming data
        $me = Auth::getUser();
        $me->name = $request->input('name');
        $me->phone = $request->input('phone');
        $me->signature = $request->input('signature');
        $me->update();

        //flash sesion message
        return redirect()->route('my_settings')->with('success', 'Se ha actualizado la información de usuario correctamente');
    }

    /**
     * Reset User password
     * Using the Rule in 
     * https://www.itsolutionstuff.com/post/laravel-change-password-with-current-password-validation-exampleexample.html
     * 
     * Forst check a lot of security gates to get here.
     */
    public function update_user_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        //flash sesion message
        return redirect()->route('my_settings')->with('success', 'Se ha actualizado la contraseña correctamente');
    }

    /**
     * Transfermoney form
     */
    public function transfer_money(Request $request)
    {
        //SEO Data
        $seo_data = [
            'title' => "Transferir dinero entre cuentas",
            'desc' => "Enviar saldo Bachecubano entre cuentas del sistema de anuncios para Cuba",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');
        $section_name = "Enviar saldo a otra cuenta";

        $user = Auth::getUser();

        return view('user.transfer', compact('section_name', 'user'));
    }

    /**
     * Transfermoney Post
     */
    public function transfer_money_post(Request $request)
    {
        //Validate this input data
        $request->validate([
            'email' => 'required|string|email',
            'amount' => 'required|numeric',
        ]);

        //Get logged in user
        $user = Auth::getUser();

        //Destination transfer email & user
        $destination_email = $request->input('email');
        $destination_user = (new User())->getByEmail($destination_email);

        //Redirec to to transfer, this User doesn't exist
        if (is_null($destination_user)) {
            //flash sesion message
            return redirect()->route('transfer_money')->with('error', 'Ha ocurrido un error, ese usuario no existe');
        }

        //Check if remitent has enough money to transfer
        if ($user->wallet->credits >= $request->input('amount')) {

            $user->wallet->deduce($request->input('amount'));
            $destination_user->wallet->credit($request->input('amount'));

            //Notify by email to the receiver
            Mail::to($destination_email)->send(new TransferReceived($destination_user, $request->input('amount')));

            return redirect()->route('transfer_money')->with('success', 'Felicidades, ha transferido ' . $request->input('amount') . ' cuc al correo ' . $destination_email);
        } else {
            return redirect()->route('transfer_money')->with('error', 'Ha ocurrido un error, no tiene saldo suficiente para transferir esa cantidad');
        }
    }

    /**
     * Send SMS dialog window
     */
    public function send_sms()
    {
        //SEO Data
        $seo_data = [
            'title' => "Enviar SMS a Cuba y el mundo",
            'desc' => "Utilice el siguiente formulario para enviar SMS a cualquier parte del mundo",
        ];
        SEOMeta::setTitle($seo_data['title']);
        SEOMeta::setDescription($seo_data['desc']);
        Twitter::setTitle($seo_data['title']);
        OpenGraph::setTitle($seo_data['title']);
        OpenGraph::setDescription($seo_data['desc']);
        OpenGraph::addProperty('type', 'website');
        $section_name = "Enviar SMS a números en el mundo";

        $user = Auth::getUser();

        return view('user.sms', compact('section_name', 'user'));
    }
}
