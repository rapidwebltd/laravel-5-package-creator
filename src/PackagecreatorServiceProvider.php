<?php namespace Rapidweb\Packagecreator;

use Illuminate\Support\ServiceProvider;

class PackagecreatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	protected $commands = [
			'Rapidweb\Packagecreator\Commands\TestCommands\ModelGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\FolderStructure\PackageFolderGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\ServiceProvider\PackageServiceProviderGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\Controller\PackageControllerGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\Routes\PackageRoutesGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\Model\PackageModelGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\View\PackageViewGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\ComposerFile\PackageComposerFileGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\Events\PackageEventGeneratorCommand',
			'Rapidweb\Packagecreator\Commands\All\PackageAllGeneratorCommand',

	];
	
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		
		//require '/var/www/fresh-laravel-5/vendor/autoload.php';
	
		//require __DIR__ . '/../vendor/autoload.php';
		require __DIR__.'/routes.php';
		
		$this->loadViewsFrom(__DIR__.'/views', 'Packagecreator');
		
		$this->publishes([__DIR__.'/views' => base_path('resources/views/vendor/Packagecreator'),]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		
		$this->commands($this->commands);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}