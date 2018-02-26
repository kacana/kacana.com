<?php namespace App\Commands;

use App\Commands\Command;
use App\services\shipGhtkService;
use Illuminate\Contracts\Bus\SelfHandling;
use App\services\shipGhnService;
use App\services\productService;

class UpdateShippingStatus extends Command implements SelfHandling {

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
	    $shipGhtkService = new shipGhtkService();

        $ships = $shipGhnService->getAllShippingProcessing();

        foreach ($ships as $ship)
        {
            if($ship->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHN)
            {
                sleep(7);
                $status = $shipGhnService->GetOrderInfoStatus($ship->id);
                $ship =  $shipGhnService->updateShippingStatus($ship->id, $status);
            }
            elseif($ship->ship_service_type == KACANA_SHIP_TYPE_SERVICE_GHTK)
            {
                $status = $shipGhtkService->GetOrderInfoStatus($ship->id);
                if($status)
                    $ship =  $shipGhnService->updateShippingStatus($ship->id, $status);
            }

            \Log::info('__CRON__ Update status ship: '. $ship->id);
        }
	}

}
