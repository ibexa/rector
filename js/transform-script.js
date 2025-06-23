const { execSync } = require('child_process');
const fs = require('fs');

const { getMainConfig, getPrettierConfigFile, getAbsolutePath } = require('./helpers');

const { config } = getMainConfig();
const { paths, prettierConfigPath } = config;
const prettierConfigFile = getPrettierConfigFile(prettierConfigPath);

paths.forEach(({ input, output }) => {
    const inputAbsolutePath = getAbsolutePath(input);
    const outputAbsolutePath = getAbsolutePath(output);

    if (!fs.existsSync(inputAbsolutePath)) {
        return;
    }

    let command = `babel ${inputAbsolutePath} -d ${outputAbsolutePath} --retain-lines`;
    command += ` && yarn prettier "${outputAbsolutePath}/**/*.js" --config ${prettierConfigFile} --write --log-level warn`;

    try {
        execSync(command, { stdio: 'inherit' });
    } catch (err) {} // eslint-disable-line no-empty
});
