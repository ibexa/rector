# Get ready to run
```
yarn --cwd ./vendor/ibexa/rector/js install
```
`--cwd` argument should point to directory where JS transform module is installed (for example `./vendor/ibexa/rector/js`). This installs node_modules inside vendor bundle.

# How to run
```
yarn --cwd ./vendor/ibexa/rector/js transform
```
`--cwd` argument should point to directory where JS transform module is installed (for example `./vendor/ibexa/rector/js`).

## Configuration file
If you need to modify default config, plugins or configuration for rules, use `rector.config.js` from main directory of bundle.
```
module.exports = {
    config: {
        paths: [{
            input: 'src/bundle/Resources/public',
            output: 'src/bundle/Resources/public',
        }],
        prettierConfigPath: './prettier.js',
    }
    plugins: (plugins) => {
        // modify enabled plugins

        return plugins;
    },
    pluginsConfig: (config) => {
        // modify plugins config

        return config;
    }
};
```

### config

#### paths
Array of objects with input and output directories for transformed files. By default it's relative to main bundle root. While transforming, structure of directories is maintained.

#### prettierConfigPath
Optional. At the end of transform there's mandatory prettier execution, which by default is taken from package https://github.com/ibexa/eslint-config-ibexa/blob/main/prettier.js

### plugins
Allows to modify enabled plugins (more about plugin below).

### pluginsConfig
Allows to modify config for plugins.
Example config:
```
{
    "ibexa-rename-string-values": {
        "ez-form-error": "ibexa-form-error",
        "ez-selection-settings": {
            "to": "ibexa-selection-settings",
            "exactMatch": true
        },
        "(^|\\s)\\.ez-": {
            "to": ".ibexa-",
            "regexp": true
        },
        "ibexa-field-edit--ez([A-Za-z0-9]+)": {
            "to": "ibexa-field-edit--ibexa$1",
            "regexp": true
        }
    }
}
```
Plugin config is kept as object with key being plugin name (`ibexa-rename-string-values` in example).

Property key inside this object is string that is supposed to be changed, can be either standard string or regex (`(^|\\s)\\.ez-`, `ezform-error"` in example)

#### Shorthand expression

`"ez-form-error": "ibexa-form-error"` - change all `ez-form-error` occurences to `ibexa-form-error`

#### Full object config properties

`"to": "ibexa-selection-settings"` - what string should be replaced with

`"regexp": true/false` - should config use regexp to match original value

`"exactMatch": true` - should match only full values, using example config, this won't change `ez-selection-settings__field` as `ez-selection-settings` is not exact match.

#### Special "shared" property
Except named plugins config, there is also possibility to create config for all plugins - its rules are later overwritten by specific plugin config if there is intersection in rules names.
```
    "shared": {
        "ez": {
            "to": "ibexa",
            "exactMatch": true,
        }
    }
```

## Default plugins
### Rename eZ global variables
This plugin changes all `eZ` variables to `ibexa`.

**Plugin name in config:** `./ibexa-rename-ez-global.js`

**Example config:** none

### Rename variables
This plugin allows to change any variable to any other value.

**Plugin name in config:** `./ibexa-rename-variables.js`

**Example config:**
```
{
    "^Ez(.*?)Validator$": {
        "to": "Ibexa$1Validator",
        "regexp": true
    },
    "^EZ_": {
        "to": "IBEXA_",
        "regexp": true
    }
}
```

**Example output:**

`class EzBooleanValidator extends eZ.BaseFieldValidator` => `class IbexaBooleanValidator extends ibexa.BaseFieldValidator`

`const EZ_INPUT_SELECTOR = 'ezselection-settings__input';` => `const IBEXA_INPUT_SELECTOR = 'ezselection-settings__input';`

### Rename string values
This plugin allows to change any string value - except translations. Can be used to transform selectors etc.

**Plugin name in config:** `./ibexa-rename-string-values.js`

**Example config:**
```
{
    "(^|\\s)\\.ez-": {
        "to": ".ibexa-",
        "regexp": true
    },
    "ibexa-field-edit--ez([A-Za-z0-9]+)": {
        "to": "ibexa-field-edit--ibexa$1",
        "regexp": true
    },
    "ezselection-settings": "ibexaselection-settings"
}
```

**Example output:**

`const SELECTOR_FIELD = '.ez-field-edit--ezboolean';` => `const SELECTOR_FIELD = ".ibexa-field-edit--ezboolean"`

`const SELECTOR_FIELD = '.ibexa-field-edit--ezboolean';` => `const SELECTOR_FIELD = '.ibexa-field-edit--ibexaboolean';`

### Rename translation IDs
This plugin allows to change translation ids. Remember to extract translations afterwards!

**Plugin name in config:** `./ibexa-rename-trans-id.js`

**Example config:**
```
{
    "^ez": {
        "to": "ibexa",
        "regexp": true
    }
}
```

**Example output:**

`'ez_boolean.limitation.pick.ez_error'` => `'ibexa_boolean.limitation.pick.ez_error'`

### Rename translation strings
This plugin allows to change translations. Remember to extract translations afterwards!

**Plugin name in config:** `./ibexa-rename-in-translations.js`

**Example config:**
```
{
    "to": "ibexa-not-$1--show-modal",
    "regexp": true,
    "selectors-only": true
}
```

**selectors-only config:** 

If this property is set to `true`, this plugin changes only strings inside html tags (like classes and other html parameters). Set to `false` or remove property to change also normal strings as well.

**Example output with selectors-only=true:**

`/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` => `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/`

**Example output with selectors-only=false:**

`/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` => `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ibexa-not-error--show-modal")*/`