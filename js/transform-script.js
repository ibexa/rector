const { execSync } = require('child_process');
const path = require('path');
const fs = require('fs');

const prettierConfigFile = require.resolve('eslint-config-ibexa/prettier');
const DEFAULT_INPUT_DIR = 'src/bundle/Resources/public,src/bundle/ui-dev/src/modules';
const { INIT_CWD, INPUT, OUTPUT, RUN_ESLINT } = process.env;
const inputValue = INPUT ?? DEFAULT_INPUT_DIR;
const outputValue = OUTPUT ?? DEFAULT_INPUT_DIR;
const inputPaths = inputValue.split(',');
const outputPaths = outputValue.split(',');

const getAbsolutePath = (pathToDir) => {
    if (path.isAbsolute(pathToDir)) {
        return pathToDir;
    }

    return path.join(INIT_CWD, pathToDir);
};

inputPaths.forEach((inputPath, index) => {
    const inputAbsolutePath = getAbsolutePath(inputPath);
    const outputAbsolutePath = outputPaths[index] ? getAbsolutePath(outputPaths[index]) : inputAbsolutePath;

    if (!fs.existsSync(inputAbsolutePath)) {
        return;
    }

    let command = `babel ${inputAbsolutePath} -d ${outputAbsolutePath} --retain-lines`;
    command += ` && yarn prettier "${outputAbsolutePath}/**/*.js" --config ${prettierConfigFile} --write`;

    if (RUN_ESLINT === '1') {
        command += ` && yarn eslint "${outputAbsolutePath}/**/*.js" --fix`;
    }

    try {
        execSync(command, { stdio: 'inherit' });
    } catch (err) {} // eslint-disable-line no-empty
});
