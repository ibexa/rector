const fs = require('fs');
const path = require('path');

const DEFAULT_CONFIG_FILE = 'removeez.config.js';

const getModifyMethod = (method) => {
    const { INIT_CWD, REMOVEEZ_CONFIG } = process.env;
    const configPath = path.join(INIT_CWD, REMOVEEZ_CONFIG ?? DEFAULT_CONFIG_FILE);
    const defaultModifyMethod = (config) => config;

    if (fs.existsSync(configPath)) {
        const modifyMethods = require(configPath);

        return modifyMethods[method] ?? defaultModifyMethod;
    }

    return defaultModifyMethod;
};

const getConfig = (name) => {
    const modifyConfig = getModifyMethod('config');
    const configPath = path.join(__dirname, 'config.json');
    const rawData = fs.readFileSync(configPath);
    const parsedData = JSON.parse(rawData);
    const modifiedData = modifyConfig(parsedData);
    const sharedConfig = modifiedData.shared ?? {};
    const namedConfig = modifiedData[name] ?? {};

    return {
        ...sharedConfig,
        ...namedConfig,
    };
};

const shouldReplace = (original, oldValue, newValueConfig) => {
    if (newValueConfig.fullMatch) {
        return original === oldValue;
    } else if (newValueConfig.regexp) {
        return !!original.match(oldValue);
    }

    return true;
};

const getValues = (oldValue, newValueConfig) => {
    if (newValueConfig.regexp) {
        return {
            oldValue: new RegExp(oldValue, 'g'),
            newValue: newValueConfig.to,
        };
    }

    return {
        oldValue,
        newValue: newValueConfig.to ?? newValueConfig,
    };
};

const traverse = (moduleConfig, originalValue, replaceData) => {
    // should it end after first replace to avoid nested replace?
    Object.entries(moduleConfig).forEach(([oldValueRaw, newValueConfig]) => {
        if (shouldReplace(originalValue, oldValueRaw, newValueConfig)) {
            const { oldValue, newValue } = getValues(oldValueRaw, newValueConfig);

            replaceData(oldValue, newValue, newValueConfig);
        }
    });
};

const isFunctionArgument = ({ parentPath }, functionName) => {
    if (!parentPath?.isCallExpression()) {
        return false;
    }

    return parentPath.node.callee.property?.name === functionName;
};

module.exports = {
    getModifyMethod,
    getConfig,
    shouldReplace,
    getValues,
    traverse,
    isFunctionArgument,
};
