<?php

namespace SmartSelect\Providers;

use Illuminate\Support\ServiceProvider;
use SmartSelect\Commands\ExportDefaultSelectColumns;
use SmartSelect\Commands\GrantUserPrivileges;

class SmartSelectServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../../config/smart-select.php', 'smart-select');
	}

	public function boot(): void
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				ExportDefaultSelectColumns::class,
				GrantUserPrivileges::class,
			]);

			// Publish config file
			$this->publishes([
				__DIR__.'/../../config/smart-select.php' => config_path('smart-select.php'),
			], 'smart-select-config');
		}
	}
}
