<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

use Rector\Symfony\CodeQuality\Rector\Class_\InlineClassRoutePrefixRector;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withSkip([
        __DIR__ . '/src/Entity',
        InlineClassRoutePrefixRector::class,
    ])
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php83: true)
    ->withAttributesSets(symfony: true, doctrine: true)
    ->withTypeCoverageLevel(1)
    ->withImportNames(removeUnusedImports: true)
    ->withComposerBased(symfony: true)
    ->withPreparedSets(
        doctrineCodeQuality: true,
    )
    // not for entity
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        earlyReturn: true,
        symfonyCodeQuality: true
    )
    ->withSets([
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ]);
