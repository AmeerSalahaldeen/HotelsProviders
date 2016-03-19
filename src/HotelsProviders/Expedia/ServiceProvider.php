<?php namespace HotelsProviders\Expedia;

use Illuminate\Foundation\AliasLoader;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        // Register the package namespace
        $this->package('HotelsProviders/Expedia');

		// Auto create app alias with boot method.
		AliasLoader::getInstance()->alias('ExpediaProviders', 'HotelsProviders\Expedia\Facade');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['HotelsProviders.expedia'] = $this->app->share(function($app)
		{
            $config = $app->config->get('HotelsProviders::config', array());

			return new ExpediaProvider($config);
		});
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
