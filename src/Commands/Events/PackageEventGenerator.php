<?php
namespace Rapidweb\Packagecreator\Commands\Events;

use Illuminate\Filesystem\Filesystem;

class PackageEventGenerator
{
	
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}
	
	//create new file
	public function make($vendorName, $packageName, $modelName, $viewName)
	{
		//clean up model name so class name always starts with capital letter
		$vendorName = ucwords($vendorName);
		$packageName = ucwords($packageName);
		$modelName = ucwords($modelName);
		$viewName = strtolower($viewName);
		
		$packagesPath = 'packages';
		$vendorPath = $packagesPath.'/'.$vendorName;
		$packagePath = $vendorPath.'/'.$packageName;
		$srcPath = $packagePath.'/src';
		$modelPath = $srcPath.'/Models';
		$controllerPath = $srcPath.'/Controllers';
		$eventPath = $srcPath.'/Events';
		$listenerPath = $srcPath.'/Handlers/Events';
		
		$modelFilePath = $modelPath.'/'.$modelName.'.php';
		$controllerFilePath = $controllerPath.'/'.$packageName.'Controller.php';
		$eventFilePath = $srcPath.'/Events/UserLoggedIn.php';
		$listenerFilePath = $srcPath.'/Handlers/Events/UserLoggedInConfirmation.php';
		$eventServiceProviderFilePath = $srcPath.'/EventServiceProvider.php';
		
		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//if events folder doesnt exist then create it
		
		if ( ! $this->file->isDirectory($eventPath))
		{
			$this->file->makeDirectory($eventPath, 0777, true, true);
		}
		
		//if listeners folder doesnt exist then create it
		if ( ! $this->file->isDirectory($listenerPath))
		{
			$this->file->makeDirectory($listenerPath, 0777, true, true);
		}

		//fetch the templates/stubs
		
		//fetch model class stub and create event class
		$eventTemplate = $this->getEventTemplate($vendorName, $packageName);
		$this->file->put($eventFilePath, $eventTemplate);
		
		//fetch model class stub and create listener class
		$listenerTemplate = $this->getListenerTemplate($vendorName, $packageName);
		$this->file->put($listenerFilePath, $listenerTemplate);
		
		//fetch controller class stub to modify existing controller
		$controllerTemplate = $this->getExistingController($vendorName, $packageName, $modelName, $viewName);
		$this->file->put($controllerFilePath, $controllerTemplate);
		
		//fetch Event Service Provider class stub create Event Service Provider class
		$controllerTemplate = $this->getEventServiceProviderTemplate($vendorName, $packageName);
		$this->file->put($eventServiceProviderFilePath, $controllerTemplate);
		
		//finally add the new Events Service Provider to the /config/app file
		$this->modifyConfigAppFile($vendorName, $packageName);

	}
	
	public function getEventTemplate($vendorName, $packageName)
	{
		//get the template/stub

		$template = $this->file->get(dirname(__DIR__).'/stubs/packageEvent.txt');
		
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
		
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);

		//replace
		return $template;
	
	}
	
	public function getListenerTemplate($vendorName, $packageName)
	{
		//get the template/stub

		$template = $this->file->get(dirname(__DIR__).'/stubs/packageListener.txt');
	
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
	
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
	
		//replace
		return $template;
	
	}
	
	public function getExistingController($vendorName, $packageName, $modelName, $viewName)
	{
		//get the template/stub
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageControllerEvent.txt');
	
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
	
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
	
		$template = str_replace('{{MODEL NAME}}',$modelName,$template);
		
		$template = str_replace('{{VIEW NAME}}',$viewName,$template);
	
		//replace
		return $template;
	
	}
	
	public function getEventServiceProviderTemplate($vendorName, $packageName)
	{
		//get the template/stub
	
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageEventServiceProvider.txt');
	
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
		if(strpos($configAppFile, $vendorName.'\\'.$packageName.'\EventServiceProvider')) return;
	
		preg_match_all("/'providers' => \[[^\]]*\]/", $configAppFile, $matches);
	
	
		$providersArray = $matches[0][0];
	
		$providersArray2 = str_replace(']', '', $providersArray);
	
		$providersArray2 = rtrim($providersArray2);
	
		$newProviderArray = $providersArray2."\n\t\t'".$vendorName."\\".$packageName."\EventServiceProvider',\n";
	
		$newProviderArray .= ']';
	
		$configAppFile = str_replace($providersArray, $newProviderArray, $configAppFile);

		$this->file->put('config/app.php', $configAppFile);
	
	}
	
}