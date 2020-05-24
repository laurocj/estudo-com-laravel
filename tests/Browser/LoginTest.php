<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    // /**
    //  * A Dusk test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/login')
    //                 ->assertSee('Laravel');
    //     });
    // }

    public function testBasicExample()
    {
        // $user = factory(User::class)->create([
        //     'email' => 'taylor@laravel.com',
        // ]);

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', '12345678')
                    ->press('LOGIN')
                    ->assertPathIs('/cms');
        });
    }
}
