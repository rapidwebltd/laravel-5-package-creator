<?php namespace Rapidweb\Packagecreator\Handlers\Events;

use Rapidweb\Admin\Events\AdminUserLoggedIn;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailAdminLoggedInConfirmation {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  PodcastWasPurchased  $event
	 * @return void
	 */
	public function handle(AdminUserLoggedIn $event)
	{
		//
		//dd('here 4');
		return $event;
		
	}

}
