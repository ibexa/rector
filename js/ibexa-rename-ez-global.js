module.exports = function ({ types: t }) {
    return {
        visitor: {
            Identifier(path) {
                if (path.node.name === 'eZ') {
                    path.node.name = t.toIdentifier('ibexa');
                }
            },
            JSXIdentifier(path) {
                if (path.node.name === 'eZ') {
                    path.node.name = t.toIdentifier('ibexa');
                }
            },
        },
    };
};
