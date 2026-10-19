<?php

namespace App\Jobs;

use App\Events\ChatEvent;
use App\Models\Chat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendChat implements ShouldQueue
{
    use Queueable ;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Chat $chat
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ChatEvent::dispatch([
            "sender_id" => $this->chat->sender_id,
            "receiver_id" => $this->chat->recevier_id,
            "message" => $this->chat->message,
        ]);
    }
}
