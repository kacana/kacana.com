<?php namespace App\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use App\services\shipService;
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
	    $shipService = new shipService();

        $ships = $shipService->getAllShippingProcessing();

        foreach ($ships as $ship)
        {
            sleep(7);
            $status = $shipService->GetOrderInfoStatus($ship->id);
            $ship =  $shipService->updateShippingStatus($ship->id, $status);

            \Log::info('__CRON__ Update status ship: '. $ship->id);
        }


	}

}
