<?php

namespace Irony\Webhook\Listeners;

use Exception;
use Flarum\Approval\Event\PostWasApproved;
use Flarum\Settings\SettingsRepositoryInterface;
use s9e\TextFormatter\Utils\Http;

class WebhookApproved
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param PostWasApproved $event
     */
    public function handle(PostWasApproved $event)
    {
        $post = $event->post;
        $discussion = $post->discussion;
        $url = $this->settings->get('irony.webhook.urls.approved');

        if ($post->number == 1 && $discussion->is_approved && $this->startsWith($url, 'http')) {
            try {
                $client = Http::getCachingClient();
                $client->post($url, [], json_encode($discussion));
            } catch (Exception $e) {
            }
        }
    }

    private function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
}