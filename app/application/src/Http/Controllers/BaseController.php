<?php

namespace App\Application\Http\Controllers;

class BaseController
{
    protected $licenseId = null;
    public function __construct()
    {
        $this->licenseId = session('licensed_context', auth()->user()->person->license_id);
    }
}