<?php

namespace App\Application\Providers;

use App\Application\Models\People;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
	public function register(): void {}

	public function boot(): void
	{
		People::observe(\App\Application\Observers\People::class);
	}
}
