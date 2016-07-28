<?php namespace App\Http\Controllers;

use App\Http\Controllers\SMSController as SMSController;
class NotLoggedIn extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth'); none needed.... they're not logged in.
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {

        
        return view('notLoggedIn',["gifURL"=>$this->getrandGif()]);
    }


     public function getrandGif()
    {
        $randEngine = rand(0,1);


        // create the context
        $arContext['http']['timeout'] = 3;
        $context = stream_context_create($arContext);
         
        // Fetch data

        ini_set('default_socket_timeout', 2);
        try{

            $string = file_get_contents('http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC', 0, $context);
            $gif = json_decode($string,true);
            $gif = $gif['data']['image_original_url'];
        }
        catch(Exception $e)
        {
            $gif = "http://i.imgur.com/DpMQwtN.gif";
        }


        return $gif;
    }   

}
