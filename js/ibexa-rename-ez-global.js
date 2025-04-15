module.exports = function ({ types }) {
    return {
        visitor: {
            Identifier(path) {
                if (path.node.name === 'eZ') {
                    path.node.name = types.toIdentifier('ibexa');
                }
            },
            JSXIdentifier(path) {
                if (path.node.name === 'eZ') {
                    path.node.name = types.toIdentifier('ibexa');
                }
            },
        },
    };
};
