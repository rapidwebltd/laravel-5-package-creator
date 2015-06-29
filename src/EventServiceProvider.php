<?php namespace Rapidweb\Packagecreator;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
			'Rapidweb\Admin\Events\AdminUserLoggedIn' => [
					'Rapidweb\Admin\Handlers\Events\EmailAdminLoggedInConfirmation',
			],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		
		parent::boot($events);
		
		\Event::listen('Rapidweb\Admin\Events\PodcastWasPurchased', function($event)
		{
			// Handle the event...
			return 'hello world';
				
		});
		

		//
	}
	
	public function register()
	{
		//
	}

}
