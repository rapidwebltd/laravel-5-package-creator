<?php 
namespace Rapidweb\Packagecreator\Commands\ComposerFile;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class PackageComposerFileGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	//protected $name = 'packagecreater:serviceprovider';
	protected $name = 'packagecreator:composerfile';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Modify the composer.json file on the root of the app to look at your new packages namespace (2)';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'File';
	
	protected $generator;
	
	public function __construct(PackageComposerFileGenerator $generate)
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
		
		$this->info($this->type.' composer.json modified successfully. Please run composer dump-autoload before running next command.');
		
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
