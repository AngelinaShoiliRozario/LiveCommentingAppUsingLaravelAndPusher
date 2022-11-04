<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('post.'.$this->comment->post->id);
    }
 
     public function broadcastWith()
    {
        return [
            'body' =>$this->comment->body,
            'created_at' =>$this->comment->created_at->toFormattedDateString(),
            'user'=>[
                'id' => $this->comment->user->id,
                'name' => $this->comment->user->name,
                'avatar' => 'http://lorempixel/50/50',
            ]
        ];
    }
}
