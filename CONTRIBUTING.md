# Contributing custom rules for Ibexa DXP

This guide is meant for adding rules to this package. For custom project rules, it's recommended to follow
[Rector's official documentation](https://getrector.com/documentation/custom-rule).

## Structure

* `./src/contracts/Sets` - directory to add global rulesets
  - `./src/contracts/Sets/ibexa-46.php` is a ruleset which contains all the rules for Ibexa DXP 4.6 which prepare for upgrade to 5.0, new rules 
    should be added there.
* `./src/lib/Rule` - directory to implement specific rules, following [Rector's official doc](https://getrector.com/documentation/custom-rule).
  - `./src/lib/Rule/Ibexa46/` - directory to implement Ibexa 4.6 upgrade specific rules.
* `./tests/lib/Rule` - directory to implement a specific rule tests, should contain subdirectory named `<RuleName>/`.
* `./tests/lib/Sets/Ibexa46/` - directory to implement specific use cases tests for Ibexa 4.6 set configuration, if not covered by Rector tests.

## Creating custom rules

This package comes with a Composer-wrapped Symfony command to generate custom rule and place its files in proper
directories, following the above structure.

```bash
composer define-custom-rule [<RuleNamespace>/]<RuleName>
```

For example, to add Ibexa v4.6 refactoring rule called Foo, execute:
```bash
composer define-custom-rule Ibexa46/Foo
```
