<?php

declare(strict_types=1);

use App\Http;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$definitions = [
  'config' => [
      'debug' => (bool)getenv('APP_DEBUG'),
  ]
];

$container = new class($definitions) implements ContainerInterface {
  private $definitions;

  public function __construct(array $definitions)
  {
      $this->definitions = $definitions;
  }

  public function get($id)
  {
      if (isset($this->definitions[$id])) {
          $definition = $this->definitions[$id];
          if (is_callable($definition)) {
              return $definition($this);
          }
          return $definition;
      }

      throw new \InvalidArgumentException("No entry or class found for '$id'");
  }

  public function has($id): bool
  {
      return isset($this->definitions[$id]);
  }
};

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware($container->get('config')['debug'], true, true);

$app->get('/', Http\Action\HomeAction::class);

$app->run();