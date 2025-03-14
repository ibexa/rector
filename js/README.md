# How to run
```
REMOVEEZ_CONFIG=./config.js INPUT=input OUTPUT=output RUN_ESLINT=1  yarn --cwd ./vendor/ibexa/rector/js transform
```
`--cwd` argument should point to directory where JS transform module is installed (for example `./vendor/ibexa/rector/js`).

## Customizable variables
### REMOVEEZ_CONFIG
**Required**: no

**Default**: `removeez.config.js`/`none`

Points to configuration file, where you can modify plugins and transformers config. 

### INPUT
**Required**: no

**Default**: `src/bundle/Resources/public`

Used to point which directory should be parsed.

### OUTPUT
**Required**: no

**Default**: copied from `INPUT`

Used to point where files should be saved.

### RUN_ESLINT
**Required**: no

**Default**: 0

Eslint parsing is switched off by default, because older code (below 4.1) was using obsolete eslint config, and in between 4.1 and current version there were different iterations, this package uses `eslint-config-ibexa` in version **1.1.1**

## Configuration file
If you need to modify default plugins or configuration for rules, put `removeez.config.js` in main directory.
```
module.exports = {
    plugins: (plugins) => {
        // modify enabled plugins

        return plugins;
    },
    config: (config) => {
        // modify plugins config

        return config;
    }
};
```

## Plugins config
Example config:
```
{
    "ibexa-rename-string-values": {
        "ezform-error": "ibexaform-error",
        "ezselection-settings": {
            "to": "ibexaselection-settings",
            "fullMatch": true
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

### Shorthand expression

`"ezform-error": "ibexaform-error"` - change all `ezform-error` occurences to `ibexaform-error`

### Full object config properties

`"to": "ibexaselection-settings"` - what string should be replaced with

`"regexp": true/false` - should config use regexp to match original value

`"fullMatch": true` - should match only full values, using example config, this won't change `ezselection-settings__field` as `ezselection-settings` is not exact match.


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