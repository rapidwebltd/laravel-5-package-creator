<?php 
namespace Rapidweb\Packagecreator\Commands\Events;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class PackageEventGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'packagecreator:eventandlisteners';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate Event and Listeners for Laravel 5 package (8)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'Event and Listeners';
	
	protected $generator;
	
	public function __construct(PackageEventGenerator $generate)
	{
		
		parent::__construct();
		
		$this->generator = $generate;
	
	}
	
	public function fire()
	{
		
		//ask the user for the name of the vendor and package
		$vendorName = $this->ask('Enter vendor name');
		
		$packageName = $this->ask('Enter package name');
		
		$modelName = $this->ask('Enter model name that you entered previously. (Tip: Singular of database name ie. Customer');
		
		$viewName = $this->ask('Enter view name that you entered previously.');
		
		//$path = $this->option('path');
		
		//generate the folders
		$this->generator->make($vendorName,$packageName,$modelName,$viewName);
		
		$this->info($this->type." created successfully and controller and /config/app file modified.");
		
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
