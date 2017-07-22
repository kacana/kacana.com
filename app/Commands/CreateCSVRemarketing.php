<?php namespace App\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use App\services\shipGhnService;
use App\services\productService;

class CreateCSVRemarketing extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
	    $shipGhnService = new shipGhnService();

        $ships = $shipGhnService->getAllShippingProcessing();

        foreach ($ships as $ship)
        {
            sleep(7);
            $status = $shipGhnService->GetOrderInfoStatus($ship->id);
            $ship =  $shipGhnService->updateShippingStatus($ship->id, $status);

            \Log::info('__CRON__ Update status ship: '. $ship->id);
        }


	}

}
