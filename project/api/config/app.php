<?php

declare(strict_types=1);

return static function (DI\Container $container) {
  $app = Slim\Factory\AppFactory::createFromContainer($container);

  (require __DIR__ . '/../config/middlewares.php')($app, $container);
  (require __DIR__ . '/../config/routes.php')($app);

  return $app;
};
