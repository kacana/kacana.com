<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\CreateCSVRemarketing',
        'App\Console\Commands\UpdateShippingStatus'

	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
//        $schedule->command('csv:everyDay')->hourly()->withoutOverlapping();
        $schedule->command('UpdateShippingStatus')->everyThirtyMinutes()->withoutOverlapping();
	}
}
