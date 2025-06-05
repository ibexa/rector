<?php

declare(strict_types=1);

use Ibexa\Rector\Rule\ChangeLimitationTypeValueObjectToObjectRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ChangeLimitationTypeValueObjectToObjectRector::class);
};
