<?php

namespace Irony\Webhook;

use Flarum\Extend;
use Flarum\Approval\Event\PostWasApproved;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Locales(__DIR__ . '/resources/locale')),
    function (Dispatcher $events) {
        $events->listen(PostWasApproved::class, Listeners\WebhookApproved::class);
    },
];
