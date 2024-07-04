<?php

namespace App\Events;

use App\Models\Bid;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(

        public $message,
        public $user_id,
        public $tender_id = null,
        public $bid_id = null,
        public $archive_id = null,

    )
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::query()->find($this->user_id);
        $tender = Tender::query()->find($this->tender_id);
        $bid = Bid::query()->find($this->bid_id);

        $content = $user->name.$tender->tender_no."Nolu İhaleye".$bid->bid_price."teklif verdi.";
    }
}
