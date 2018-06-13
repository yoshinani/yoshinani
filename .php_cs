<?php

$includedPaths = [
    'app',
    'config',
    'database',
    'domain',
    'infrastructure',
    'routes',
    'tests',
];

$excludedPaths = [
    'bootstrap',
    'public',
    'resources',
    'setup',
    'storage',
    'vendor',
];

$excludedRules = [
    'psr0',
];

$rules = [
    '@PSR2' => true,
    '@PHP71Migration' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => [
        'align_double_arrow' => true,
        'align_equals' => true,
    ],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_return' => true,
    'blank_line_before_statement' => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try'
        ]
    ],
    'braces' => [
        'allow_single_line_closure' => false,
        'position_after_anonymous_constructs' => 'next',
        'position_after_control_structures' => 'same',
        'position_after_functions_and_oop_constructs' => 'next'
    ],
    'cast_spaces' => [
        'space' => 'single'
    ],
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'compact_nullable_typehint' => true,
    'concat_space' => [
        'spacing' => 'one'
    ],
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => [
        'closure_function_spacing' => 'one',
    ],
    'function_typehint_space' => true,
    'include' => true,
    'increment_style' => [
        'style' => 'pre'
    ],
    'indentation_type' => true,
    'line_ending' => true,
    'linebreak_after_opening_tag' => true,
    'list_syntax' => [
        'syntax' => 'long'
    ],
    'lowercase_cast' => true,
    'lowercase_constants' => true,
    'lowercase_keywords' => true,
    'method_argument_space' => [
        'ensure_fully_multiline' => false,
        'keep_multiple_spaces_after_comma' => false,
    ],
    'method_argument_space' => [
        'ensure_fully_multiline' => true,
    ],
    'method_argument_space' => [
        'keep_multiple_spaces_after_comma' => false,
    ],
    'method_separation' => true,
    'new_with_braces' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_blank_lines_before_namespace' => true,
    'no_break_comment' => true,
    'no_closing_tag' => true,
    'no_empty_comment' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines' => [
        'tokens' => ['extra']
    ],
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_mixed_echo_print' => [
        'use' => 'echo'
    ],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_short_bool_cast' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_superfluous_elseif' => true,
    'no_useless_else' => true,
    'no_superfluous_elseif' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => [
        'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield']
    ],
    'no_unneeded_curly_braces' => true,
    'no_unneeded_final_method' => true,
    'no_unused_imports' => true,
    'ordered_imports' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
];

$finder = PhpCsFixer\Finder::create()->exclude($excludedPaths)->in($includedPaths);

return PhpCsFixer\Config::create()->setRules($rules)->setFinder($finder);