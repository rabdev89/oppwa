<?php

namespace Rabcreatives\Oppwa\Console;

use Illuminate\Console\Command;
use Rabcreatives\Oppwa\Facades\Oppwa;

class ProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oppwa:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Oppwa Processing Checkout.';


    /**
     * Execute the console command.
     *
     *
     * @return mixed
     */
    public function handle()
    {
        if (Oppwa::configNotPublished()) {
            return $this->warn('Please publish the config file by running ' .
                '\'php artisan vendor:publish --tag=oppwa-config\'');
        }
    }
}
