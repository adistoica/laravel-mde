<?php

namespace AdrianStoica\LaravelMde;

class EditorServiceProvider extends \Illuminate\Support\ServiceProvider
{
/**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Configuration
        $configPath = __DIR__ . '/../config/editor.php';
        $this->mergeConfigFrom($configPath, 'editor');
        $this->publishes([$configPath => config_path('editor.php')], 'config');
        // Public resource
        $publicPath = __DIR__ . '/../public';
        $this->publishes([$publicPath => public_path('')], 'public');
        // View
        $viewPath = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewPath, 'editor');
        // Routes
        $routePath = __DIR__ . '/Http/routes.php';
        if (! $this->app->routesAreCached()) {
            require $routePath;
        }
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['editor'];
    }
}