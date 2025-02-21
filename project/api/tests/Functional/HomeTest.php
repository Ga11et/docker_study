<?php

declare(strict_types=1);

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class HomeTest extends TestCase
{
  public function testSuccess(): void
  {
    require __DIR__ . '/../../vendor/autoload.php';

    /** @var ContainerInterface $container */
    $container = require __DIR__ . '/../../config/container.php';

    /** @var Slim\App $app */
    $app = (require __DIR__ . '/../../config/app.php')($container);

    $request = (new ServerRequestFactory())
      ->createServerRequest('GET', '/');

    $response = $app->handle($request);

    self::assertEquals(200, $response->getStatusCode());
    self::assertEquals('{}', (string) $response->getBody());
  }
}