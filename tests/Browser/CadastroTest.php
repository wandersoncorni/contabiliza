<?php

use Laravel\Dusk\Browser;
//use Illuminate\Support\Facades\Artisan;

//Artisan::call('migrate:fresh --seed');

test('example', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/register')
        ->type('name', 'Cliente')
        ->type('email', 'cliente@contabiliza.com')
        ->type('password', 'Senha@123')
        ->type('password_confirmation', 'Senha@123')
        ->check('terms')
        ->click('button[type="submit"]')
        ->assertSee('register');
    });
});
