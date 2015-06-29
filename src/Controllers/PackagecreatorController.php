<?php
namespace Rapidweb\Packagecreator\Controllers;

use App\Http\Controllers\Controller;
use Rapidweb\Admin\Models\Customer;
use Rapidweb\Admin\Events\AdminUserLoggedIn;
use Rapidweb\Admin\Events\PodcastWasPurchased;

class PackagecreatorController extends Controller
{
	public function __construct()
	{
		//echo 'Admin controller worked';
		//die;
		
	}
	
	public function addToFileTest()
	{
		$in1 = "
		hello world, my name is andrew and my number is 845 235-0184
		
		
		";
		
		$String = '{
	"name": "laravel/laravel",
	"description": "The Laravel Framework.",
	"keywords": ["framework", "laravel"],
	"license": "MIT",
	"type": "project",
	"require": {
		"laravel/framework": "5.1.*"
	},
	"require-dev": {
		"phpunit/phpunit": "~4.0",
		"phpspec/phpspec": "~2.1",
		"laracasts/generators": "^1.1"
	},
	"autoload": {
		"classmap": [
			"database"
		],
		"psr-4": {
			"App\\": "app/",
			"Rapidweb\\Admin\\": "packages/Rapidweb/Admin/src",
			"Company\\Admin\\": "packages/Company/Admin/src"
		}
	},
	"autoload-dev": {
		"classmap": [
			"tests/TestCase.php"
		]
	},
	"scripts": {
		"post-install-cmd": [
			"php artisan clear-compiled",
			"php artisan optimize"
		],
		"pre-update-cmd": [
        		"php artisan clear-compiled"
        	],
		"post-update-cmd": [
			"php artisan optimize"
		],
		"post-create-project-cmd": [
			"php -r \"copy(\'.env.example\', \'.env\');\"",
			"php artisan key:generate"
		]
	},
	"config": {
		"preferred-install": "dist"
	}
}
		';
		
		//echo $String;
		//die;
		
		//$String ="'providers' => [ddfgh]";
		
		
		//preg_match("~providers(.*?)]~", $String, $output);
		
		
		//print_r($output);
		
		
		//preg_match_all("/'providers' => \[[^\]]*\]/", $String, $matches3);
		
		
		preg_match_all("/\"psr-4\": \{[^\}]*/", $String, $matches);
		
		//?echo($matches[0][0]);
		
		//die;
		
		$providersArray = $matches[0][0];
		
		//$providersArray = str_replace(']', '', $providersArray);
		
		$providersArray = rtrim($providersArray);
		
		$newProviderArray = $providersArray."\n\t\t'Blah\Test\TestServiceProvider',\n";
		
		//$newProviderArray = $providersArray.',\n\t\t"Blah\Test\": "packages/Blah/Test/src"\n';
		
		$newProviderArray = $providersArray.",\n\t\t\t'Blah\Test\': 'packages/Blah/Test/src'\n";
		
		$newProviderArray .= '}';
		
		$newProviderArray = str_replace("'", '"', $newProviderArray);
		
		echo $newProviderArray;
		
		//$final = str_replace($providersArray, $newProviderArray, $String);
		
		//echo $newProviderArray;
		
		die;
		
		
		//echo($matches[0][0]);
		
		//preg_match_all('/\(([A-Za-z0-9 ]+?)\)/', $in, $out);
		//print_r($out);
		
		
		
		//die;
	}
	
	public function o_package_test()
	{
		
		//echo '<br />Controller worked';
		//die;
		
		$customers = Customer::all();
		
		//dd($customers);
		
		return view('Admin::test')->with('customers',$customers);
		
		//return view('Admin::test');
		
	}
	
	public function o_event_test()
	{
			
			$eventInfo_1 = \Event::fire(new AdminUserLoggedIn(8, 9));
			
			$eventInfo_2 = \Event::fire(new PodcastWasPurchased(1, 2));
			
			dd($eventInfo_1,$eventInfo_2);
			
			$eventInfo_2 = $eventInfo_2[0];
			
			//dd($eventInfo_2);
			
	}
	
}