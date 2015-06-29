<?php 
namespace Rapidweb\Packagecreator\Commands\View;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class PackageViewGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'packagecreator:view';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a view for a Laravel 5 package and modify controller to return view (7)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'View';
	
	protected $generator;
	
	public function __construct(PackageViewGenerator $generate)
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
		
		$viewName = $this->ask('Enter view name.');
		
		//$path = $this->option('path');
		
		//generate the folders and files
		$this->generator->make($vendorName,$packageName,$modelName,$viewName);
		
		$this->info($this->type.' created successfully.');
		
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
