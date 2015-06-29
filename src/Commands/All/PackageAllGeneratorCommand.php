<?php 
namespace Rapidweb\Packagecreator\Commands\All;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Rapidweb\Packagecreator\Commands\FolderStructure\PackageFolderGenerator;
use Rapidweb\Packagecreator\Commands\ComposerFile\PackageComposerFileGenerator;
use Rapidweb\Packagecreator\Commands\ServiceProvider\PackageServiceProviderGenerator;
use Rapidweb\Packagecreator\Commands\Controller\PackageControllerGenerator;
use Rapidweb\Packagecreator\Commands\Routes\PackageRoutesGenerator;
use Rapidweb\Packagecreator\Commands\Model\PackageModelGenerator;
use Rapidweb\Packagecreator\Commands\View\PackageViewGenerator;
use Rapidweb\Packagecreator\Commands\Events\PackageEventGenerator;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;


class PackageAllGeneratorCommand extends Command{
	
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	//protected $name = 'packagecreater:serviceprovider';
	protected $name = 'packagecreator:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create all package folders and files';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'Package';
	
	protected $packageFolderGenerator;
	private $packageComposerFileGenerator;
	private $packageServiceProviderGenerator;
	private $packageControllerGenerator;
	private $packageRoutesGenerator;
	private $packageModelGenerator;
	private $packageViewGenerator;
	private $packageEventGenerator;
	
	public function __construct(PackageFolderGenerator $packageFolderGenerator, PackageComposerFileGenerator $packageComposerFileGenerator, PackageServiceProviderGenerator $packageServiceProviderGenerator, PackageControllerGenerator $packageControllerGenerator, PackageRoutesGenerator $packageRoutesGenerator, PackageModelGenerator $packageModelGenerator, PackageViewGenerator $packageViewGenerator, PackageEventGenerator $packageEventGenerator)
	{
		
		parent::__construct();
		
		$this->packageFolderGenerator = $packageFolderGenerator;
		$this->packageComposerFileGenerator = $packageComposerFileGenerator;
		$this->packageServiceProviderGenerator = $packageServiceProviderGenerator;
		$this->packageControllerGenerator = $packageControllerGenerator;
		$this->packageRoutesGenerator = $packageRoutesGenerator;
		$this->packageModelGenerator = $packageModelGenerator;
		$this->packageViewGenerator = $packageViewGenerator;
		$this->packageEventGenerator = $packageEventGenerator;
		
	}
	
	public function fire()
	{
		
		//ask the user for the name of the vendor and package
		$vendorName = $this->ask('Enter vendor name');
		
		$packageName = $this->ask('Enter package name');
		
		$modelName = $this->ask('Enter model name. (Tip: Singular of database name ie. Customer');
		
		$viewName = $this->ask('Enter view name');

		$this->packageFolderGenerator->make($vendorName,$packageName);
		
		$this->packageComposerFileGenerator->make($vendorName,$packageName);

		system('composer dump-autoload');
		
		$this->packageServiceProviderGenerator->make($vendorName,$packageName);
		
		$this->packageControllerGenerator->make($vendorName,$packageName);
		
		$this->packageRoutesGenerator->make($vendorName,$packageName);
		
		$this->packageModelGenerator->make($vendorName,$packageName,$modelName);
		
		//create database table
		
		$databaseTable = strtolower($modelName).'s';
		
		if (!\Schema::hasTable($databaseTable)){
			
			\Schema::create($databaseTable, function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('full_name');
			});
			
			DB::table($databaseTable)->insert(
			['full_name' => 'Test Name 1']
			);
			
			DB::table($databaseTable)->insert(
			['full_name' => 'Test Name 2']
			);
			
			DB::table($databaseTable)->insert(
			['full_name' => 'Test Name 3']
			);
			
		}
		
		$this->packageViewGenerator->make($vendorName,$packageName,$modelName,$viewName);
		
		$this->packageEventGenerator->make($vendorName,$packageName,$modelName,$viewName);
		
		
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
	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to directory.','packages/Rapidweb/Admin/src/Controllers'),
		);
	}

}
