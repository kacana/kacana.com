<?php namespace App\Commands;

use App\Commands\Command;

use App\services\socialService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class PostToSocial extends Command implements SelfHandling, ShouldBeQueued {

    use InteractsWithQueue, SerializesModels;

    public $_payload;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->_payload = $payload;
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $socialService = new socialService();

        $payload = base64_decode($this->_payload);
        $data = json_decode($payload);
        \Log::info('__QUEUE__ PROCESSING post to social with social post id: '. $data->socialPostId);
        $socialService->postToSocial($data->socialPostId, $data->userId, $data->social, $data->images, $data->desc);

        \Log::info('__QUEUE__ SUCCESS post to social with social post id: '. $data->socialPostId);
    }

}
