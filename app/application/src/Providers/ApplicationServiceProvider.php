<?php

namespace App\Application\Providers;

use App\AccessControl\Models\User;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
	public function register(): void {}

	public function boot(): void
	{
		User::observe(\App\Application\Observers\User::class);
	}
}
