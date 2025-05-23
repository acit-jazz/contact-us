<?php

namespace AcitJazz\ContactUs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AcitJazz\ContactUs\ContactUs
 */
class ContactUs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AcitJazz\ContactUs\ContactUs::class;
    }
}
