# Contributing custom rules for Ibexa DXP

This guide is meant for adding rules to this package. For custom project rules, it's recommended to follow
[Rector's official documentation](https://getrector.com/documentation/custom-rule).

## Structure

* `./src/contracts/Sets` - directory to add global rulesets
  - `./src/contracts/Sets/ibexa-50.php` is a ruleset which contains all the rules for Ibexa DXP 5.0 upgrade, new rules 
    should be added there.
* `./src/lib/Rules` - directory to implement specific rules, following [Rector's official doc](https://getrector.com/documentation/custom-rule).
  - `./src/lib/Rules/Ibexa50/` - directory to implement Ibexa 5.0 upgrade specific rules  
* `./tests/lib/Rector` - directory to implement a specific rule tests, should contain subdirectory named `<RuleName>/` 

