<?php
namespace Rapidweb\Packagecreator\Commands\FolderStructure;

use Illuminate\Filesystem\Filesystem;

class PackageFolderGenerator
{
	
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}
	
	//create new file
	public function make($vendorName, $packageName)
	{
		
		$packagesPath = 'packages';
		$vendorPath = $packagesPath.'/'.$vendorName;
		$packagePath = $vendorPath.'/'.$packageName;
		$srcPath = $packagePath.'/src';
		
		//folders to go into src directory
		$srcFolders = array(
			$srcPath.'/Controllers',
			$srcPath.'/Events',
			$srcPath.'/Handlers/Events',
			$srcPath.'/Models',
			$srcPath.'/views'
		);
		
		/*
		$controllersPath = $srcPath.'/Controllers';
		$eventsPath = $srcPath.'/Events';
		$handlersPath = $srcPath.'/Handlers';
		$modelsPath = $srcPath.'/Models';
		$viewsPath = $srcPath.'/views';
		*/	
		
		//if this package folder doesnt exist then create it
		if ( ! $this->file->isDirectory($srcPath))
		{
			$this->file->makeDirectory($srcPath, 0777, true, true);
		}
		
		//create all folders within src directory
		foreach($srcFolders as $folder)
		{

			if ( ! $this->file->isDirectory($folder))
			{
				$this->file->makeDirectory($folder, 0777, true, true);
			}
			
		}
		
		
		//then put our new file into the folder
		//$this->file->put($path, $template);
		
		
	}

	
}