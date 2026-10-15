<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavigationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_desktop_navbar_highlights_the_active_link(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1280, 900)
                ->visit('/dashboard')
                ->waitForText('Dashboard')
                ->assertVisible('header nav a[href$="/dashboard"]')
                ->assertAttributeContains('header nav a[href$="/dashboard"]', 'class', 'bg-primary')
                ->assertMissing('[aria-label="Open menu"]');
        });
    }

    public function test_mobile_hamburger_menu_lists_nav_links(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(480, 900)
                ->visit('/dashboard')
                ->waitFor('[aria-label="Open menu"]')
                ->assertMissing('header nav')
                ->click('[aria-label="Open menu"]')
                ->waitFor('header ul.menu a[href$="/dashboard"]')
                ->assertVisible('header ul.menu a[href$="/dashboard"]');

            $browser->resize(1280, 900);
        });
    }

    public function test_user_dropdown_links_to_settings_pages(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1280, 900)
                ->visit('/dashboard')
                ->waitFor('.avatar[role="button"]')
                ->click('.avatar[role="button"]')
                ->waitForText('Profile')
                ->clickLink('Profile')
                ->waitForLocation('/settings/profile')
                ->assertSee('Profile Information');
        });
    }
}
