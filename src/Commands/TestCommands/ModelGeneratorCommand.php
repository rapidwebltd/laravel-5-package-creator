<?php 
namespace Rapidweb\Packagecreator\Commands\TestCommands;

//use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class ModelGeneratorCommand extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'g:usercreatorcommand';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a new model';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	//this type is just to let the user know that it what file was successfully created. (see bottom of fire method)
	protected $type = 'Model';
	
	protected $generator;
	
	public function __construct(ModelGenerator $generate)
	{
		
		parent::__construct();
		
		$this->generator = $generate;
	
	}
	
	public function fire()
	{
		
		//calculate the name of the model
		$model = $this->argument('name');
		
		$path = $this->option('path');
		
		//generate the class
		$this->generator->make($model,$path);
		
		$this->info($this->type.' created successfully.');
		
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		
		return array(
				array('name', InputArgument::REQUIRED, 'The name of the model to generate.'),
		);
		
	}

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
