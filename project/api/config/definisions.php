<?php

declare(strict_types=1);

$pattern = __DIR__ . '/' . ((string) getenv('APP_ENV') ?: 'prod') . '/*.php';

$files = array_merge(
    glob(__DIR__ . '/common/*.php'),
    glob($pattern)
);


$configs = array_map(
    static function (string $file): array {
        /**
         * @var array
         * @noinspection PhpIncludeInspection
         * @psalm-suppress UnresolvableInclude
         */
        return require $file;
    },
    $files
);

return array_merge_recursive(...$configs);
