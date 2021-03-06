<?php

namespace Irony\Webhook;

use Flarum\Extend;
use Flarum\Post\Event\Saving as PostSaved;
use Flarum\Approval\Event\PostWasApproved;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Locales(__DIR__ . '/resources/locale')),
    function (Dispatcher $events) {
        $events->listen(PostSaved::class, Listeners\WebhookSaved::class);
        $events->listen(PostWasApproved::class, Listeners\WebhookApproved::class);
    },
];
