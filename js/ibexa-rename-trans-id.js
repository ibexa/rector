const { getConfig, traverse, isFunctionArgument } = require('./helpers.js');

const moduleConfig = getConfig('ibexa-rename-trans-id');

module.exports = function () {
    return {
        visitor: {
            StringLiteral(path) {
                if (!isFunctionArgument(path, 'trans')) {
                    return;
                }

                traverse(moduleConfig, path.node.value, (oldValue, newValue) => {
                    path.node.value = path.node.value.replace(oldValue, newValue);
                });
            },
        },
    };
};
