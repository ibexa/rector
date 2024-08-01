const { getConfig, traverse } = require('./helpers.js');

const moduleConfig = getConfig('ibexa-rename-in-translations');

module.exports = function () {
    return {
        visitor: {
            Identifier(path) {
                if (path.node.name !== 'trans') {
                    return;
                }
                const parentCallExpresion = path.findParent((parentPath) => parentPath.isCallExpression());
                const translationComment = parentCallExpresion?.node.arguments[0]?.leadingComments[0];

                if (translationComment) {
                    traverse(moduleConfig, translationComment.value, (oldValue, newValue, config) => {
                        if (config['selectors-only']) {
                            const regexp = new RegExp(`<[a-zA-Z0-9-_]*? .*?=(?:[\\"\\'])(.*?)\\1.*?>`, 'g');
                            const matches = translationComment.value.match(regexp);

                            matches?.forEach((match) => {
                                const valueToReplace = match.replaceAll(oldValue, newValue);

                                translationComment.value = translationComment.value.replaceAll(match, valueToReplace);
                            });
                        } else {
                            translationComment.value = translationComment.value.replaceAll(oldValue, newValue);
                        }
                    });
                }
            },
        },
    };
};
