<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateWeatherDispatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;
    private string $data;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function broadcastWith()
    {  
        return [
            'user' => $this->user,
            'data' => json_decode($this->data, true),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('weather');
    }

    public function broadcastAs()
    {
        return 'weatherUpdated';
    }
}
