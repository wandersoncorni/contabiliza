<?php

use Illuminate\Support\Facades\Route;

foreach (glob(base_path('app/*/routes/web.php')) as $routeFile) {
    require $routeFile;
}