<?php

$includedPaths = [
    'app',
    'config',
    'database',
    'resources',
    'routes',
    'tests',
];

$excludedPaths = [
    'bootstrap',
    'laradock.d',
    'public',
    'storage',
    'vendor',
];

$excludedRules = [
    'psr0',
];

$rules = [
    '@PSR2'                                 => true,
    'binary_operator_spaces'                => true,
    'no_empty_statement'                    => true,
    'trailing_comma_in_multiline_array'     => true,
    'array_syntax'                          => ['syntax' => 'short'],
    'no_trailing_comma_in_singleline_array' => true,
];

$finder = PhpCsFixer\Finder::create()->exclude($excludedPaths)->in($includedPaths);

return PhpCsFixer\Config::create()->setRules($rules)->setFinder($finder);