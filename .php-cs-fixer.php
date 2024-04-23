<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use PhpCsFixer\Finder;
use Ibexa\CodeStyle\PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->files()->name('*.php');

$config = new Config();
$config->setFinder($finder);

return $config;
