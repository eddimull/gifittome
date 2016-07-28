<?php

namespace App\Console;
use Log;
use SMS;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Users;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function()
        {
            $string = file_get_contents("http://api.giphy.com/v1/gifs/trending?api_key=dc6zaTOxFJmzC");
            $gif = json_decode($string,true);
            $users = Users::where('gifOfTheDay',1)->get();
            foreach ($users as $user) {
                 SMS::send('SMS.blank', ['theMessage'=>'gif of the day! To unsubscribe, text back -g stop gotd.'], function($sms) use ($gif,$user){
                    $sms->to($user->phoneNumber);
                    $sms->attachImage($gif['data'][0]['images']['original']['url']);
                });
            }
            // SMS::send('SMS.blank', ['theMessage'=>$gif['data']['image_url']], function($sms) {
            //     // $sms->to('3373357172');
            //     $sms->to('2819140203');
            // });

        // })->everyMinute();
        })->at('12:00');
    }
}
