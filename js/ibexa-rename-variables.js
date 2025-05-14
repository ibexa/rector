const { getRulesConfig, traverse } = require('./helpers.js');

const moduleConfig = getRulesConfig('ibexa-rename-variables');

module.exports = function ({ types }) {
    return {
        visitor: {
            Identifier(path) {
                traverse(moduleConfig, path.node.name, (oldValue, newValue) => {
                    const newIdentifier = path.node.name.replace(oldValue, newValue);

                    path.node.name = types.toIdentifier(newIdentifier);
                });
            },
            JSXIdentifier(path) {
                traverse(moduleConfig, path.node.name, (oldValue, newValue) => {
                    const newIdentifier = path.node.name.replace(oldValue, newValue);

                    path.node.name = types.toIdentifier(newIdentifier);
                });
            },
        },
    };
};
