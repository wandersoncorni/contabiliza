<?php

namespace App\Api;

use App\AccessControl\Services\RBACService;

class BaseController
{
    protected $rbacService;
    public function __construct(RBACService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function getRBACService()
    {
        return $this->rbacService;
    }
}