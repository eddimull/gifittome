<?php namespace App\Providers;

class SmsServiceProvider extends \Illuminate\Hashing\HashServiceProvider {

    public function boot()
    {
        parent::boot();

        $this->app->bindShared('hash', function()
        {
            return new \Snappy\Hashing\ScryptHasher;
        });
    }
    //     /**
    //  * Receives a SMS via a push request.
    //  *
    //  * @return IncomingMessage
    //  */
    // public function receive()
    // {
    //     //Passes all of the request onto the driver.
    //     $raw = $this->container['Input'];
    //     return $this->driver->receive($raw);
    // }

}