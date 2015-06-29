<?php 
namespace Rapidweb\Packagecreator\Commands\ServiceProvider;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class PackageServiceProviderGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	//protected $name = 'packagecreater:serviceprovider';
	protected $name = 'packagecreator:serviceprovider';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate the service provider for a Laravel 5 package and add to config/app.php providers array (3)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'Service Provider';
	
	protected $generator;
	
	public function __construct(PackageServiceProviderGenerator $generate)
	{
		
		parent::__construct();
		
		$this->generator = $generate;
	
	}
	
	public function fire()
	{
		
		//ask the user for the name of the vendor and package
		$vendorName = $this->ask('Enter vendor name');
		
		$packageName = $this->ask('Enter package name');
		
		//$path = $this->option('path');
		
		//generate the folders
		$this->generator->make($vendorName,$packageName);
		
		$this->info($this->type.' created and config/app.php file modified successfully.');
		
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
	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to directory.','packages/Rapidweb/Admin/src/Controllers'),
		);
	}

}
