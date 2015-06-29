<?php namespace Rapidweb\Packagecreator\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class PodcastWasPurchased extends Event {

	use SerializesModels;
	
	public $userId;
	public $podcastId;
	
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($userId, $podcastId)
	{
		$this->userId = $userId;

		$this->podcastId = $podcastId;
		
	}


}
