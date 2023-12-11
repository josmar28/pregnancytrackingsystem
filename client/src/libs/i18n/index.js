import Vue from 'vue'
import VueI18n from 'vue-i18n'
import {getCookie} from "@core/mixins/helpers";

Vue.use(VueI18n)

function loadLocaleMessages() {
	const locales = require.context('./locales', true, /[A-Za-z0-9-_,\s]+\.js$/i);
	const messages = {}
	locales.keys().forEach(key => {
		const matched = key.match(/([A-Za-z0-9-_]+)\./i);
		if (matched && matched.length > 1) {
			const locale = matched[1];
			messages[locale] = locales(key).default;
		}
	})

	return {...messages}
}

export default new VueI18n({
	locale: getCookie('locale', 'en'),
	fallbackLocale: 'en',
	messages: loadLocaleMessages(),
})
