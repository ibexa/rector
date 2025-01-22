# Ibexa DXP Rector

This package is part of [Ibexa DXP](https://ibexa.co).

This package provides a set of [Rector](https://getrector.com/) rules to allow automatic upgrades between
[Ibexa DXP](https://ibexa.co) versions.

To use this package, [install Ibexa DXP](https://doc.ibexa.co/en/latest/install/) and follow installation instructions
below.

## Installation

```
composer require --dev ibexa/rector:~5.0.x-dev
```

## Usage

1. Create `./rector.php` file in your project, with the following contents, adjusted to your project structure:
   ```php
   declare(strict_types=1);

   use Ibexa\Contracts\Rector\Sets\IbexaSetList;
   use Rector\Config\RectorConfig;

   return RectorConfig::configure()
                      ->withPaths(
                          [
                              __DIR__ . '/src', // see if it matches your project structure
                              __DIR__ . '/tests'
                          ]
                      )
                      ->withSets(
                          [
                              IbexaSetList::IBEXA_50->value // rule set for upgrading to Ibexa DXP 5.0
                          ]
                      )
   ;
   ```
2. Execute Rector
    ```
    php ./bin/rector process <directory>
    ```

## CONTRIBUTING

See [contribution guideline](./CONTRIBUTING.md) to learn how to add rules.

## COPYRIGHT

Copyright (C) 1999-2025 Ibexa AS (formerly eZ Systems AS). All rights reserved.

## LICENSE

This source code is available separately under the following licenses:

A - Ibexa Business Use License Agreement (Ibexa BUL),
version 2.4 or later versions (as license terms may be updated from time to time)
Ibexa BUL is granted by having a valid Ibexa DXP (formerly eZ Platform Enterprise) subscription,
as described at: https://www.ibexa.co/product
For the full Ibexa BUL license text, please see:
- LICENSE-bul file placed in the root of this source code, or
- https://www.ibexa.co/software-information/licenses-and-agreements (latest version applies)

AND

B - GNU General Public License, version 2
Grants an copyleft open source license with ABSOLUTELY NO WARRANTY. For the full GPL license text, please see:
- LICENSE file placed in the root of this source code, or
- https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
