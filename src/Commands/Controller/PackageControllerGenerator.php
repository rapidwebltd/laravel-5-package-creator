<?php
namespace Rapidweb\Packagecreator\Commands\Controller;

use Illuminate\Filesystem\Filesystem;

class PackageControllerGenerator
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
		$controllerPath = $srcPath.'/Controllers';
		
		$path = $controllerPath.'/'.$packageName.'Controller.php';

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
		
		
	}
	
	public function getTemplate($vendorName, $packageName)
	{
		//get the template/stub
		//dd(dirname(__DIR__));
		$template = $this->file->get(dirname(__DIR__).'/stubs/packageController.txt');
		
		$template = str_replace('{{VENDOR NAME}}',$vendorName,$template);
		
		$template = str_replace('{{PACKAGE NAME}}',$packageName,$template);
		
		//replace
		return $template;
	
	}

	
}