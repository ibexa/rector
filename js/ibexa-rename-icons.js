const { getRulesConfig, traverse, isFunctionArgument } = require('./helpers.js');

const moduleConfig = getRulesConfig('ibexa-rename-icons');
const forcedExactMatchModuleConfig = Object.entries(moduleConfig).reduce((output, [key, value]) => {
    return {
        ...output,
        [key]: {
            ...(typeof value === 'string' ? { to: value } : value),
            exactMatch: value.exactMatch ?? true,
        },
    };
}, {});

module.exports = function () {
    return {
        visitor: {
            StringLiteral(path) {
                if (!isFunctionArgument(path, 'getIconPath')) {
                    return;
                }

                traverse(forcedExactMatchModuleConfig, path.node.value, (oldValue, newValue) => {
                    path.node.value = path.node.value.replace(oldValue, newValue);
                });
            },
        },
    };
};
