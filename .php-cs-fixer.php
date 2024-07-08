<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/app/')
    ->in(__DIR__.'/config/')
    ->in(__DIR__.'/database/')
    ->in(__DIR__.'/routes/')
    ->in(__DIR__.'/tests/');

$config = (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());

return $config->setRules([
    '@Symfony' => true,
    'no_empty_comment' => false,
    'method_argument_space' => [
        'keep_multiple_spaces_after_comma' => false,
    ],
    'array_indentation' => true,
])->setFinder($finder);
