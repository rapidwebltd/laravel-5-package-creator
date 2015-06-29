<?php
namespace Rapidweb\Packagecreator\Commands\View;

use Illuminate\Filesystem\Filesystem;

class PackageViewGenerator
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
		$viewPath = $srcPath.'/views';
		
		$modelFilePath = $modelPath.'/'.$modelName.'.php';
		$controllerFilePath = $controllerPath.'/'.$packageName.'Controller.php';
		$viewFilePath = $viewPath.'/'.$viewName.'.blade.php';
		
		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//if folder doesnt exist then create it
		if ( ! $this->file->isDirectory(dirname($viewFilePath)))
		{
			$this->file->makeDirectory(dirname($viewFilePath), 0777, true, true);
		}

		//fetch the templates/stubs
		
		//fetch view class stub and create model class
		$viewTemplate = $this->getViewTemplate($vendorName, $packageName, $modelName);
		$this->file->put($viewFilePath, $viewTemplate);
		
		//fetch controller class stub to modify existing controller
		$controllerTemplate = $this->getExistingController($vendorName, $packageName, $modelName, $viewName);
		$this->file->put($controllerFilePath, $controllerTemplate);

	}
	
	public function getViewTemplate($vendorName, $packageName, $modelName)
	{
		//get the template/stub
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageView.txt');
		
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
		
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
		
		$template = str_replace('{{MODEL NAME}}',$modelName,$template);
		
		//replace
		return $template;
	
	}
	
	public function getExistingController($vendorName, $packageName, $modelName, $viewName)
	{
		//get the template/stub
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageControllerView.txt');
	
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
	
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
	
		$template = str_replace('{{MODEL NAME}}',$modelName,$template);
		
		$template = str_replace('{{VIEW NAME}}',$viewName,$template);
	
		//replace
		return $template;
	
	}

	
}