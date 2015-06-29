<?php 
namespace Rapidweb\Packagecreator\Commands\Model;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class PackageModelGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'packagecreator:model';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a model for a Laravel 5 package (6)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'Model';
	
	protected $generator;
	
	public function __construct(PackageModelGenerator $generate)
	{
		
		parent::__construct();
		
		$this->generator = $generate;
	
	}
	
	public function fire()
	{
		
		//ask the user for the name of the vendor and package
		$vendorName = $this->ask('Enter vendor name');
		
		$packageName = $this->ask('Enter package name');
		
		$modelName = $this->ask('Enter model name. (Tip: Singular of database name ie. Customer');
		
		//$path = $this->option('path');
		
		//generate the folders
		$this->generator->make($vendorName,$packageName,$modelName);
		
		$this->info($this->type." created successfully and controller file modified. Now please create a table in your database called ".strtolower($modelName)."s and add a column called 'full_name' along with a few records in it.");
		
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	/*protected function getArguments()
	{
		
		return array(
				array('name', InputArgument::REQUIRED, 'The name of the model to generate.'),
		);
		
	}*/

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	/*
	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to directory.','packages/Rapidweb/Admin/src/Controllers'),
		);
	}
	*/

}
