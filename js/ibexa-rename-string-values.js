const { getRulesConfig, traverse, isFunctionArgument } = require('./helpers.js');

const moduleConfig = getRulesConfig('ibexa-rename-string-values');

module.exports = function () {
    return {
        visitor: {
            TemplateElement(path) {
                if (isFunctionArgument(path, 'trans')) {
                    return;
                }

                traverse(moduleConfig, path.node.value.raw, (oldValue, newValue) => {
                    path.node.value.raw = path.node.value.raw.replace(oldValue, newValue);
                    path.node.value.cooked = path.node.value.cooked.replace(oldValue, newValue);
                });
            },
            StringLiteral(path) {
                if (isFunctionArgument(path, 'trans')) {
                    return;
                }

                traverse(moduleConfig, path.node.value, (oldValue, newValue) => {
                    path.node.value = path.node.value.replace(oldValue, newValue);
                });
            },
        },
    };
};
