# JavaScript Transform module

The JavaScript Transform module is a command-line tool you can use to automatically refactor your JavaScript code.

# Usage

## Install dependencies

To install the dependencies, execute the following command:
``` bash
yarn --cwd ./vendor/ibexa/rector/js install
```
`--cwd` argument must point to the directory where the transform module is installed, by default `./vendor/ibexa/rector/js`.

# Running transformations

``` bash
yarn --cwd ./vendor/ibexa/rector/js transform
```
`--cwd` argument must point to the directory where the transform module is installed, by default `./vendor/ibexa/rector/js`.

## Configuration

To adjust the default configuration, plugins, or rules, modify the `rector.config.js` file present in your project or bundle directory:

``` js
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

### Configuration options

#### `paths`

Array of objects with input and output directories for transformed files, relative to your project or bundle root. 
Directory structure is not modified during the transformation.

#### `prettierConfigPath`

[Prettier](https://prettier.io/) is run at the end of the transformation. 
You can provide the path to your own configuration file, otherwise [the default file](https://github.com/ibexa/eslint-config-ibexa/blob/main/prettier.js) is used.

### `plugins`

Use it to modify enabled plugins. 
To learn more about plugins, see [the list of plugins](#list-of-plugins).

### `pluginsConfig`

Use this setting to modify the plugins configuration, as in the example below:
``` js
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

The plugin configuration is an object with plugin names as keys, for example `ibexa-rename-string-values`.
Inside a single plugin configuration, the property names are values that should be replaced.
They can be specified explicitly (`ezform-error`) or by using regexp (`(^|\\s)\\.ez-`).

#### Shorthand expression

You can use a shorthand form to specify the configuration:

- `"ez-form-error": "ibexa-form-error"` - changes all `ez-form-error` occurrences to `ibexa-form-error`

#### Complete plugin configuration

When not using the shorthand configuration, the following options are available:

- `"to": "ibexa-selection-settings"` - specifies the new value
- `"regexp": true/false` - use regexp to find the matching values. Use capture groups to reuse parts of the original value in the new value
- `"exactMatch": true` - replace matching values only when the whole value is matched. Using the example configuration, `ez-selection-settings__field` would not be replaced as it doesn't match `ez-selection-settings` exactly

#### Special "shared" property

You can create a shared configuration for all plugins by using the `shared` keyword, as in the example below:
``` js
    "shared": {
        "ez": {
            "to": "ibexa",
            "exactMatch": true,
        }
    }
```

Values specifies in the `shared` configuration can be overwritten using configuration for specific plugins.

## List of plugins

### Rename eZ global variables

This plugin changes all `eZ` variables to `ibexa`.

**Name:** `ibexa-rename-ez-global`

**Configuration:** none

### Rename variables
This plugin allows to rename any variable.

**Name:** `ibexa-rename-variables`

**Configuration example:**

``` js
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

**Example:**

| Before | After |
|---|---|
| `class EzBooleanValidator extends eZ.BaseFieldValidator` | `class IbexaBooleanValidator extends ibexa.BaseFieldValidator` |
| `const EZ_INPUT_SELECTOR = 'ezselection-settings__input';` | `const IBEXA_INPUT_SELECTOR = 'ezselection-settings__input';` |

### Rename string values

This plugin changes any string value - except translations. You can use it to transform selectors and other values.

**Name:** `ibexa-rename-string-values`

**Configuration example:**
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

| Before | After |
|---|---|
| `const SELECTOR_FIELD = '.ez-field-edit--ezboolean';` | `const SELECTOR_FIELD = '.ibexa-field-edit--ezboolean'` |
| `const SELECTOR_FIELD = '.ibexa-field-edit--ezboolean';` | `const SELECTOR_FIELD = '.ibexa-field-edit--ibexaboolean';` |

### Rename translation IDs
This plugin allows to change translation ids.
Extract translations after running this transformation.

**Name:** `ibexa-rename-trans-id`

**Configuration example:**
``` js
{
    "^ez": {
        "to": "ibexa",
        "regexp": true
    }
}
```

**Example output:**

| Before | After |
|---|---|
|`'ez_boolean.limitation.pick.ez_error'` | `'ibexa_boolean.limitation.pick.ez_error'` |

### Rename translation strings
This plugin changes values in translations.
Extract translations after running this transformation.

**Name:** `ibexa-rename-in-translations`

**Configuration example:**

``` js
{
    "to": "ibexa-not-$1--show-modal",
    "regexp": true,
    "selectors-only": true
}
```

**`selectors-only`:** 

If this property is set to `true`, this plugin changes only strings inside HTML tags.
Set to `false` or remove property to change text values as well.

**Example output:**

| `selectors-only` value | Before | After |
|---|---|---|
| true | `/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/`  | `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` |
| false | `/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` |  `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ibexa-not-error--show-modal")*/` |

### Rename icons names used in getIconPath method
This plugin allows you to rename any icon name that is passed as an argument to the `getIconPath` method.

**Name:** `ibexa-rename-icons`

**Configuration example:**

In this plugin, the `exactMatch` default value is set `true` when using the shorthand expression.

``` js
{
    "browse": "folder-browse",
    "content-": {
        to: "file-",
        exactMatch: false
    }
}
```

**Example:**

| Before | After |
|---|---|
| `getIconPath('browse')` | `getIconPath('folder-browse')` |
