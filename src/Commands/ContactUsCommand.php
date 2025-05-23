<?php

namespace AcitJazz\ContactUs\Commands;

use Illuminate\Console\Command;

class ContactUsCommand extends Command
{
    public $signature = 'contact-us';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
