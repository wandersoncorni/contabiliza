<?php

use Illuminate\Support\Facades\Route;

foreach (glob(base_path('app/*/routes/api.php')) as $routeFile) {
    require $routeFile;
}