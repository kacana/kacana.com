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
        \Log::info('Tạo cron job trong laravel phần 2');
//        $productService = new productService();
//        $productService->createCsvBD();
	}

}
