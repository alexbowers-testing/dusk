<?php

namespace Laravel\Dusk;

use Exception;
use Laravel\Dusk\Chrome\SupportsChrome;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Foundation\Testing\TestCase as FoundationTestCase;

abstract class TestCase extends FoundationTestCase
{
    use Concerns\ProvidesBrowser,
        SupportsChrome;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        Browser::$baseUrl = $this->baseUrl();

        Browser::$storeScreenshotsAt = base_path('tests/Browser/screenshots');

        Browser::$storeConsoleLogAt = base_path('tests/Browser/console');

        Browser::$userResolver = function () {
            return $this->user();
        };
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://127.0.0.1:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @return string
     */
    protected function baseUrl()
    {
        return config('app.url');
    }

    /**
     * Return the default user to authenticate.
     *
     * @return \App\User|int|null
     * @throws \Exception
     */
    protected function user()
    {
        throw new Exception("User resolver has not been set.");
    }
}
