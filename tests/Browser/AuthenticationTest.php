<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_register(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/register')
                ->waitFor('#name')
                ->type('#name', 'Dusk User')
                ->type('#email', 'dusk@example.com')
                ->type('#password', 'password')
                ->type('#password_confirmation', 'password')
                ->press('Register')
                ->waitForLocation('/dashboard')
                ->assertSee("You're logged in, Dusk User.");
        });

        $this->assertDatabaseHas('users', ['email' => 'dusk@example.com']);
    }

    public function test_user_can_log_in_and_out(): void
    {
        $user = User::factory()->create(['name' => 'Jane Doe']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                ->visit('/login')
                ->waitFor('#email')
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->press('Log in')
                ->waitForLocation('/dashboard')
                ->assertSee("You're logged in, Jane Doe.")
                ->click('.avatar[role="button"]')
                ->waitForText('Log out')
                ->press('Log out')
                ->waitForLocation('/')
                ->assertGuest();
        });
    }

    public function test_invalid_credentials_show_an_error(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                ->visit('/login')
                ->waitFor('#email')
                ->type('#email', $user->email)
                ->type('#password', 'wrong-password')
                ->press('Log in')
                ->waitForText('These credentials do not match our records.')
                ->assertPathIs('/login')
                ->assertGuest();
        });
    }

    public function test_guests_are_redirected_from_the_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/dashboard')
                ->waitForLocation('/login')
                ->assertPathIs('/login');
        });
    }
}
