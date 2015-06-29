<?php
namespace Rapidweb\Packagecreator\Commands\Model;

use Illuminate\Filesystem\Filesystem;

class PackageModelGenerator
{
	
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}
	
	//create new file
	public function make($vendorName, $packageName, $modelName)
	{
		//clean up model name so class name always starts with capital letter
		$vendorName = ucwords($vendorName);
		$packageName = ucwords($packageName);
		$modelName = ucwords($modelName);
		
		$packagesPath = 'packages';
		$vendorPath = $packagesPath.'/'.$vendorName;
		$packagePath = $vendorPath.'/'.$packageName;
		$srcPath = $packagePath.'/src';
		$modelPath = $srcPath.'/Models';
		$controllerPath = $srcPath.'/Controllers';
		
		$modelFilePath = $modelPath.'/'.$modelName.'.php';
		$controllerFilePath = $controllerPath.'/'.$packageName.'Controller.php';
		
		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//if folder doesnt exist then create it
		if ( ! $this->file->isDirectory(dirname($modelFilePath)))
		{
			$this->file->makeDirectory(dirname($modelFilePath), 0777, true, true);
		}

		//fetch the templates/stubs
		
		//fetch model class stub and create model class
		$modelTemplate = $this->getModelTemplate($vendorName, $packageName, $modelName);
		$this->file->put($modelFilePath, $modelTemplate);
		
		//fetch controller class stub to modify existing controller
		$controllerTemplate = $this->getExistingController($vendorName, $packageName, $modelName);
		$this->file->put($controllerFilePath, $controllerTemplate);

	}
	
	public function getModelTemplate($vendorName, $packageName, $modelName)
	{
		//get the template/stub
		//dd(dirname(__DIR__));
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageModel.txt');
		
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
		
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
		
		$template = str_replace('{{MODEL NAME}}',$modelName,$template);
		
		//replace
		return $template;
	
	}
	
	public function getExistingController($vendorName, $packageName, $modelName)
	{
		//get the template/stub
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageControllerModel.txt');
	
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
	
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
	
		$template = str_replace('{{MODEL NAME}}',$modelName,$template);
	
		//replace
		return $template;
	
	}

	
}