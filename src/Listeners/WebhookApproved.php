<?php

namespace Irony\Webhook\Listeners;

use Flarum\Approval\Event\PostWasApproved;
use s9e\TextFormatter\Utils\Http\Client;

class WebhookApproved extends Client
{
    protected $client;

    /**
     * WebhookApproved constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->timeout = $client->timeout;
        $this->sslVerifyPeer = $client->sslVerifyPeer;
    }

    /**
     * @param PostWasApproved $event
     */
    public function handle(PostWasApproved $event)
    {
        $post = $event->post;
        $discussion = $post->discussion;

        if ($post->number == 1 && $discussion->is_approved) {
            $headers = ['Content-Type' => 'application/json;charset=utf-8'];
            $this->client->post('http://127.0.0.1:9999/pyqtsite', $headers, json_encode($discussion));
        }
    }
}