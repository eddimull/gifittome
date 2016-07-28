<?php namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider extends \Illuminate\Auth\EloquentUserProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
    	
    }

    public function retrieveByCredentials(array $credentials)
    {
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value)
        {

            if ( ! str_contains($key, 'password')) $query->where($key, $value);

        }
        return $query->first();
    }
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}








// use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
// use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// class UserProvider extends ServiceProvider {
 
// 	public function boot(DispatcherContract $events)
// 	{

// 		parent::boot($events);

// 		Auth::extend('test', function()
// 		{
// 			return 'heller';
// 		});
// 	}
	
// }





// use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
// use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// class EventServiceProvider extends ServiceProvider {

// 	/**
// 	 * The event handler mappings for the application.
// 	 *
// 	 * @var array
// 	 */
// 	protected $listen = [
// 		'event.name' => [
// 			'EventListener',
// 		],
// 	];

// 	/**
// 	 * Register any other events for your application.
// 	 *
// 	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
// 	 * @return void
// 	 */
// 	public function boot(DispatcherContract $events)
// 	{
// 		parent::boot($events);

// 		//
// 	}

// }
