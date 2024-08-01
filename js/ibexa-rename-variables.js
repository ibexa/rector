const { getConfig, traverse } = require('./helpers.js');

const moduleConfig = getConfig('ibexa-rename-variables');

module.exports = function ({ types: t }) {
    return {
        visitor: {
            Identifier(path) {
                traverse(moduleConfig, path.node.name, (oldValue, newValue) => {
                    const newIdentifier = path.node.name.replace(oldValue, newValue);

                    path.node.name = t.toIdentifier(newIdentifier);
                });
            },
            JSXIdentifier(path) {
                traverse(moduleConfig, path.node.name, (oldValue, newValue) => {
                    const newIdentifier = path.node.name.replace(oldValue, newValue);

                    path.node.name = t.toIdentifier(newIdentifier);
                });
            },
        },
    };
};
