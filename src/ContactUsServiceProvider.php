<?php

namespace AcitJazz\ContactUs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AcitJazz\ContactUs\Commands\ContactUsCommand;

class ContactUsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('contact-us')
            ->hasRoutes('web')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                    'create_contact_submissions_table'
                ])
            ->hasCommand(ContactUsCommand::class);
    }
    public function packageBooted()
    {
        // Publish JS/Vue resources to the main app
        $this->publishes([
            __DIR__ . '/../resources/js/admin/contact-us/' => resource_path('js/admin/contact-us'),
            __DIR__ . '/../resources/js/frontend/contact-us/' => resource_path('js/frontend/contact-us'),
        ], 'contact-us-assets');
    }
}
