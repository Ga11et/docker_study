<?php

declare(strict_types=1);

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(require __DIR__ . '/definisions.php');
return $builder->build();
