import app from 'flarum/app';

import WebhookSettingsModal from './components/WebhookSettingsModal';

app.initializers.add('irony-webhook', app => {
    app.extensionSettings['irony-webhook'] = () => app.modal.show(new WebhookSettingsModal());
});