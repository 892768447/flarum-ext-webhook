import SettingsModal from "flarum/components/SettingsModal";
import Switch from "flarum/components/Switch";

export default class WebhookSettingsModal extends SettingsModal {
    className() {
        return "Modal--small";
    }

    title() {
        return app.translator.trans("flarum-ext-webhook.admin.settings.title");
    }

    form() {
        return [
            <div className="Form-group">
                <label>
                    {app.translator.trans("flarum-ext-webhook.admin.settings.approved_label")}
                </label>
                <input
                    required
                    className="FormControl"
                    placeholder="https://"
                    bidi={this.setting("irony.webhook.urls.approved")}
                />
            </div>
        ];
    }
}
