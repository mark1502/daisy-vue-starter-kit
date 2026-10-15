<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ThemeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_theme_picker_applies_and_persists_the_selected_theme(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->resize(1280, 900)
                ->visit('/dashboard')
                ->waitFor('summary[title="Theme Selector"]')
                ->click('summary[title="Theme Selector"]')
                ->clickAtXPath("//details//button[normalize-space()='dracula']");

            $this->assertTheme($browser, 'dracula');

            $browser->refresh()->waitFor('summary[title="Theme Selector"]');

            $this->assertTheme($browser, 'dracula');

            $browser->script("localStorage.removeItem('theme')");
        });
    }

    public function test_guest_theme_toggle_switches_between_light_and_dark(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/login')
                ->waitFor('label.swap');

            $expected = $this->currentTheme($browser) === 'dark' ? 'light' : 'dark';

            $browser->click('label.swap');

            $this->assertTheme($browser, $expected);

            $browser->refresh()->waitFor('label.swap');

            $this->assertTheme($browser, $expected);

            $browser->script("localStorage.removeItem('guestTheme')");
        });
    }

    private function currentTheme(Browser $browser): ?string
    {
        return $browser->script("return document.documentElement.getAttribute('data-theme')")[0];
    }

    private function assertTheme(Browser $browser, string $theme): void
    {
        $browser->waitUntil("document.documentElement.getAttribute('data-theme') === '{$theme}'");

        $this->assertSame($theme, $this->currentTheme($browser));
    }
}
