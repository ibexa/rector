const { getModifyMethod } = require('./js/helpers.js');

module.exports = function (api) {
    const modifyPlugins = getModifyMethod('plugins');
    const ibexaPlugins = [
        './js/ibexa-rename-ez-global.js',
        './js/ibexa-rename-variables.js',
        './js/ibexa-rename-string-values.js',
        './js/ibexa-rename-trans-id.js',
        './js/ibexa-rename-in-translations.js',
        './js/ibexa-rename-icons.js',
    ];
    const finalPlugins = modifyPlugins(ibexaPlugins);

    api.cache(true);

    const presets = [];
    const plugins = ['@babel/plugin-syntax-jsx', ...finalPlugins];

    return {
        presets,
        plugins,
    };
};
