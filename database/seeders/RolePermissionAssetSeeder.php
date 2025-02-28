<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\AccesssControl\Models\Permission;
use App\AccesssControl\Models\Role;
use App\AccesssControl\Models\Asset;

class RolePermissionAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $userRole = Role::where('name', 'user')->first();

        // Get permissions
        $editPost = Permission::where('name', 'edit')->first();
        $deletePost = Permission::where('name', 'delete')->first();
        $viewPost = Permission::where('name', 'read')->first();

        $assetPost = Asset::where('name', 'post')->first();
        $assetArticle = Asset::where('name', 'article')->first();
        $assetView = Asset::where('name', 'view')->first();
        // Attach permissions to roles
        $adminRole->permissions()->attach([$editPost->id, $deletePost->id, $viewPost->id]);
        $editorRole->permissions()->attach([$editPost->id, $viewPost->id]);
        $userRole->permissions()->attach([$viewPost->id]);
    }
}
