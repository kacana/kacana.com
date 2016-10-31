<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Bus;
class CreateCSVRemarketing extends Command{
    /**
     * @var string
     */
    protected $name = 'csv:everyDay';

    /**
     * @var string
     */
    protected $description = 'Command description.';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        Bus::dispatchFromArray('App\Commands\CreateCSVRemarketing', []);
    }
}