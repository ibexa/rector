const fs = require('fs');
const path = require('path');

const CONFIG_FILENAME = 'rector.config.js';

let savedMainConfig = null;

const getMainConfig = () => {
    if (savedMainConfig) {
        return savedMainConfig;
    }

    const { INIT_CWD } = process.env;
    const fallbackConfigPath = path.resolve('js', CONFIG_FILENAME);
    const customConfigPath = path.resolve(INIT_CWD, CONFIG_FILENAME);

    if (fs.existsSync(customConfigPath)) {
        savedMainConfig = require(customConfigPath);
    } else if (fs.existsSync(fallbackConfigPath)) {
        savedMainConfig = require(fallbackConfigPath);
    } else {
        throw new Error(`Config file not found: ${customConfigPath} or ${fallbackConfigPath}`);
    }

    return savedMainConfig;
};

const getPrettierConfigFile = (prettierConfigPath) => {
    if (fs.existsSync(prettierConfigPath)) {
        return prettierConfigPath;
    }

    return require.resolve('eslint-config-ibexa/prettier');
};
const getAbsolutePath = (pathToDir) => {
    if (path.isAbsolute(pathToDir)) {
        return pathToDir;
    }

    return path.join(process.env.INIT_CWD, pathToDir);
};

const getModifyMethod = (method) => {
    const mainConfig = getMainConfig();

    return mainConfig[method] ?? ((config) => config);
};

const getRulesConfig = (name) => {
    const modifyConfig = getModifyMethod('config');
    const rulesConfigPath = path.join(__dirname, 'rules.config.json');
    const rawData = fs.readFileSync(rulesConfigPath);
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
    if (newValueConfig.exactMatch) {
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
    getMainConfig,
    getPrettierConfigFile,
    getAbsolutePath,
    getModifyMethod,
    getRulesConfig,
    shouldReplace,
    getValues,
    traverse,
    isFunctionArgument,
};
