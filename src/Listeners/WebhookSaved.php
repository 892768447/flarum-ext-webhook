<?php

namespace Irony\Webhook\Listeners;

use Exception;
use Flarum\Post\Event\Saving;
use Flarum\Settings\SettingsRepositoryInterface;
use s9e\TextFormatter\Utils\Http;

class WebhookSaved
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
     * @param Saving $event
     */
    public function handle(Saving $event)
    {
        $post = $event->post;
        if (!$post->exists) {
            $post->afterSave(function ($post) {
                if ($post->number == 1) {
                    $url = $this->settings->get('irony.webhook.urls.approved');
                    if ($this->startsWith($url, 'http')) {
                        try {
                            $client = Http::getCachingClient();
                            $client->post($url, [], json_encode($post->discussion));
                        } catch (Exception $e) {
                        }
                    }

                }
            });
        }
    }

    private function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
}