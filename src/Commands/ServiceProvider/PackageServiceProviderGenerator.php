<?php
namespace Rapidweb\Packagecreator\Commands\ServiceProvider;

use Illuminate\Filesystem\Filesystem;

class PackageServiceProviderGenerator
{
	
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}
	
	//create new file
	public function make($vendorName, $packageName)
	{
		//clean up model name so class name always starts with capital letter
		$vendorName = ucwords($vendorName);
		$packageName = ucwords($packageName);
		
		$packagesPath = 'packages';
		$vendorPath = $packagesPath.'/'.$vendorName;
		$packagePath = $vendorPath.'/'.$packageName;
		$srcPath = $packagePath.'/src';
		
		$path = $srcPath.'/'.$packageName.'ServiceProvider.php';

		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//fetch the template/stub
		$template = $this->getTemplate($vendorName, $packageName);
		
		//if folder doesnt exist then create it
		if ( ! $this->file->isDirectory(dirname($path)))
		{
			$this->file->makeDirectory(dirname($path), 0777, true, true);
		}
		
		//then put our new file into the folder
		$this->file->put($path, $template);
		
		$this->modifyConfigAppFile($vendorName, $packageName);

		//create resources/view folder for this vendor and package (saves the user having to run the 'php artisan vendor:publish' command)
		$resourcesViewPackageFolder = "resources/views/vendor/".$packageName;

		$this->file->makeDirectory($resourcesViewPackageFolder, 0777, true, true);
		
	}
	
	public function getTemplate($vendorName, $packageName)
	{
		//get the template/stub
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageServiceProvider.txt');
		
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
		
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
		
		//replace
		return $template;
	
	}
	
	public function modifyConfigAppFile($vendorName, $packageName)
	{
		//get the template/stub
		$configAppFile = $this->file->get('config/app.php');
		
		//dd($configAppFile);
		
		//if already in app file then don't re-add it
		if(strpos($configAppFile, $vendorName.'\\'.$packageName.'\\'.$packageName.'ServiceProvider')) return;
		
		preg_match_all("/'providers' => \[[^\]]*\]/", $configAppFile, $matches);
		
		
		$providersArray = $matches[0][0];
		
		$providersArray2 = str_replace(']', '', $providersArray);
		
		$providersArray2 = rtrim($providersArray2);
		
		$newProviderArray = $providersArray2."\n\t\t'".$vendorName."\\".$packageName."\\".$packageName."ServiceProvider',\n";
		
		$newProviderArray .= ']';
		
		$configAppFile = str_replace($providersArray, $newProviderArray, $configAppFile);
		
		//dd($configAppFile);
		
		$this->file->put('config/app.php', $configAppFile);
		
		
	
	}

	
}