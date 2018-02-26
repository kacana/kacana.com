<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Bus;
class UpdateShippingStatus extends Command{
    /**
     * @var string
     */
    protected $name = 'UpdateShippingStatus';

    /**
     * @var string
     */
    protected $description = 'Update Shipping Status by shipping service';

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        Bus::dispatchFromArray('App\Commands\UpdateShippingStatus', []);
    }
}