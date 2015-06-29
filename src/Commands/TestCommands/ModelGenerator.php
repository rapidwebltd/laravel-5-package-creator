<?php
namespace Rapidweb\Packagecreator\Commands\TestCommands;

use Illuminate\Filesystem\Filesystem;

class ModelGenerator
{
	
	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}
	
	//create new file
	public function make($model, $path)
	{
		//clean up model name so class name always starts with capital letter
		$model = ucwords($model);
		
		$path = $path.'/'.$model.'.php';

		//below is same as above but neater
		//$path = "{$path}/{$model}.php"
		
		//fetch the template/stub
		$template = $this->getTemplate($model);
		
		//if folder doesnt exist then create it
		if ( ! $this->file->isDirectory(dirname($path)))
		{
			$this->file->makeDirectory(dirname($path), 0777, true, true);
		}
		
		//then put our new file into the folder
		$this->file->put($path, $template);
		
		
	}
	
	public function getTemplate($name)
	{
		//get the template/stub
		$template = $this->file->get(__DIR__.'/templates/model.txt');
		
		//replace
		return str_replace('{{NAME}}',$name,$template);
		
	}
	
}