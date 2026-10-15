<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SettingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_settings_sidebar_navigates_between_pages(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/settings/profile')
                ->waitForText('Profile Information')
                ->assertPresent('aside a.menu-active[href$="/settings/profile"]')
                ->clickLink('Password')
                ->waitForLocation('/settings/password')
                ->assertPresent('aside a.menu-active[href$="/settings/password"]')
                ->within('aside', fn (Browser $aside) => $aside->clickLink('Delete Account'))
                ->waitForLocation('/settings/account')
                ->assertPresent('aside a.menu-active[href$="/settings/account"]');
        });
    }

    public function test_user_can_update_profile_information(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/settings/profile')
                ->waitFor('#name')
                ->clear('#name')
                ->type('#name', 'Renamed User')
                ->press('Save')
                ->waitForText('Saved.');
        });

        $this->assertSame('Renamed User', $user->fresh()->name);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/settings/account')
                ->waitForText('Once your account is deleted')
                ->within('section', fn (Browser $section) => $section->press('Delete Account'))
                ->waitFor('#password')
                ->type('#password', 'password')
                ->within('form', fn (Browser $form) => $form->press('Delete Account'))
                ->waitForLocation('/')
                ->assertGuest();
        });

        $this->assertModelMissing($user);
    }
}
