<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use SMS;
use Log;

use App\Classes\smsCommand;

use App\smsLog;
use App\Users;

class SMSController extends Controller
{

    public $user;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function receive()
    {
        //$theMessage = ['message'=>"Hi, Surah!"];
        // SMS::send('SMS.blank', ['theMessage'=>"Hi, Surah!"], function($sms) {
        //     // $sms->to('3373357172');
        //     $sms->to('2819140203');
        // });
        $incoming =  SMS::receive();

        if($this->checkNumber($incoming))
        {


                $this->user = Users::where('phoneNumber',$incoming->from())->first(); 
                $theUser = $this->user;
                SMS::send('SMS.blank', ['theMessage'=>$this->processMessage($incoming->message())], function($sms) use ($theUser){
                  // $sms->to('3373357172');
                  $sms->to($theUser->phoneNumber);
                });
            
        }

    }

    public function test()
    {
        // return $this->processMessage();
        // $string = file_get_contents("http://api.giphy.com/v1/gifs/trending?api_key=dc6zaTOxFJmzC&limit=1");
        // $gif = json_decode($string,true);

        $searchTerm = null;
         // $string = file_get_contents("http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&tag=" . rawurlencode($searchTerm));
         //        $gif = json_decode($string,true);
        $message = "-g help";
        // $commandArray = ['help'=>'$this->help()','stop gotd'=>'$this->stopGotd()','gimme gotd'=>'$this->startGotd()'];
        $command = new smsCommand(trim(str_replace("-g","",$message)));
        echo $command->process();
                // dd($gif['data']['image_original_url']);
        // SMS::send('SMS.blank', ['theMessage'=>'gif of the day!'], function($sms) use ($gif){
        //     $sms->to('+12819140203');
        //     $sms->attachImage($gif['data'][0]['images']['original']['url']);
        // });
    }

    private function processMessage($message = "quack")
    {
        $mesgArr = explode(' ', $message);
        $response = null;

        // dd($mesgArr[0]);
        if($mesgArr[0] === "-g" || (strtolower($message) == "yeah" && $this->user->verified == false))
        {
            $command = new smsCommand(trim(str_replace("-g","",$message)), $this->user);
            $response = $command->process();
        }
        else 
        {
            $response = $this->search($message);
        }
        return $response;
    }

    private function search($message)
    {
        $searchTerm = trim(str_replace("search","",$message));
        return $this->getGif($searchTerm);
    }   
    private function checkNumber($incoming)
    {
        $user = Users::where('phoneNumber',$incoming->from())->where('verified',true)->first();
        // $user = Users::where('phoneNumber','+12819140203')->where('verified',true)->first();

        // error_log($useruser);

        $valid = false;
        if(empty($user) && strtolower($incoming->message()) !== "yeah")
        {
          $verified = Users::where('phoneNumber',$incoming->from())->first();          
          if(empty($verified))
            {
              SMS::send('SMS.blank', ['theMessage'=>'Not a user. goto http://gifittome.io to sign up for your daily gif goodness'], function($sms) use ($incoming){
                  // $sms->to('3373357172');
                  $sms->to($incoming->from());
              });
            }
            else
            {
             SMS::send('SMS.blank', ['theMessage'=>'User not validated. You want to be validated? Respond back with the word: yeah'], function($sms) use ($incoming){
                  // $sms->to('3373357172');
                    // error_log($incoming->from());
                  $sms->to($incoming->from());
              });
            }
        }
        else
        {
            $valid = true;
        }
        return $valid;
    }

    public function getGif($searchTerm = null)
    {
        // $searchTerm = 'asdfsafgafdhadh';
        $randEngine = rand(0,2);
        // $randEngine = 2;
        $gif = 'No gif for you!';
        switch($randEngine)
        {
            case 0:
                $string = file_get_contents("http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC&tag=" . rawurlencode($searchTerm));
                $gif = json_decode($string,true);
                 $gif = "gif for you! \r\n" . $gif['data']['image_original_url'];
            case 1:  
                if($searchTerm == null)
                {      
                    $searchTerm = $this->randomAdjective();
                }
                $string = file_get_contents("http://searchendpoint.gfycat.com/cajax/search?search_text=" . rawurlencode($searchTerm));
                $jsonGif = json_decode($string,true);
                if(!empty($jsonGif['gfycatResults']))
                {
                    $gif = "gif for you!\r\n" .  $jsonGif['gfycatResults'][array_rand($jsonGif['gfycatResults'])]['gifUrl'];
                }
            case 2:
                if($searchTerm == null)
                {      
                   
                    $searchTerm = $this->randomAdjective();
                }
                $string = file_get_contents("http://api.gifme.io/v1/gifs/random?key=rX7kbMzkGu7WJwvG&term=" . rawurlencode($searchTerm));
                $jsonGif = json_decode($string,true);
                $notFound = ["http://i.imgur.com/Y8UM4HT.gif","http://i.imgur.com/PbOZ1ek.png","http://24.media.tumblr.com/a997566653712fc8b897132a947d98e1/tumblr_mpexbnloCV1soqenlo1_250.gif",".imgur.com/PbOZ1ek.png","http://24.media.tumblr.com/e1a323c5ab0c671c38f0f7e052b0bd40/tumblr_n1n8t3qTEc1rtew9mo2_250.gif"];
                if(!in_array($jsonGif['gif']['gif'],$notFound))
                {
                    $gif = "gif for you!\r\n" .  $jsonGif['gif']['gif'];
                }
                
        }

        return $gif;
    }   
    private function randomAdjective()
    {
         $randomAdjective = explode("\n",file_get_contents("http://test.gfycat.com/adjectives"));
         return $randomAdjective[array_rand($randomAdjective)];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
