<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('roles');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->unique('asset_label');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        // Schema::create('users_roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->unsignedBigInteger('role_id');
        //     $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        //     $table->timestamps();
        //     $table->timestamp('deleted_at')->nullable();
        // });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unsignedBigInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('actions');
        Schema::dropIfExists('assets');
    }
};
