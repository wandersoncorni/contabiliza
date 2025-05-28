<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

abstract class AppFactory extends Factory
{
    protected function resolveModelName(): string
    {
        $factoryClass = get_class($this); // Ex: App\AccessControl\Database\Factories\UserRoleFactory
        $parts = explode('\\', $factoryClass);

        $module = $parts[1] ?? null;
        $factoryName = class_basename($factoryClass); // UserRoleFactory
        $modelName = Str::replaceLast('Factory', '', $factoryName);

        return "App\\$module\\Model\\$modelName";
    }
}
