<?php
namespace Rapidweb\Packagecreator\Commands\ComposerFile;

use Illuminate\Filesystem\Filesystem;

class PackageComposerFileGenerator
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
		
		$path = 'composer.json';

		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//fetch the template/stub
		/*$template = $this->getTemplate($vendorName, $packageName);
		
		//if folder doesnt exist then create it
		if ( ! $this->file->isDirectory(dirname($path)))
		{
			$this->file->makeDirectory(dirname($path), 0777, true, true);
		}
		
		//then put our new file into the folder
		$this->file->put($path, $template);
		*/
		
		$this->modifyComposerJsonFile($vendorName, $packageName);
		
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
	
	public function modifyComposerJsonFile($vendorName, $packageName)
	{
		//get the template/stub
		$composerJsonFile = $this->file->get('composer.json');
				
		//if already in composer.json file then don't re-add it
		if(strpos($composerJsonFile, '"'.$vendorName.'\\\\'.$packageName.'\\\"')) return;
		
		
		preg_match_all("/\"psr-4\": \{[^\}]*/", $composerJsonFile, $matches);
		
		

		$providersArray = $matches[0][0];

		$providersArray2 = rtrim($providersArray);

		$newProviderArray = $providersArray2.",\n\t\t\t'".$vendorName."\\\\".$packageName."\\\': 'packages/".$vendorName."/".$packageName."/src'\n";
		
		//$newProviderArray .= '}}';
		
		$newProviderArray = str_replace("'", '"', $newProviderArray);
		
		
		
		//$composerJsonFile = str_replace($providersArray, $newProviderArray, $composerJsonFile);
		
		
		
		$composerJsonFile = str_replace($providersArray, $newProviderArray, $composerJsonFile);
		
		//echo $composerJsonFile;
		
		$this->file->put('composer.json', $composerJsonFile);

	
	}

}