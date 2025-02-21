<?php

declare(strict_types=1);

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class WebTestCase extends TestCase
{
  protected static function json(string $method, string $path): ServerRequestInterface
  {
    return self::request($method, $path)
      ->withHeader('Content-Type', 'application/json')
      ->withHeader('Accept', 'application/json');
  }

  protected static function request(string $method, string $path): ServerRequestInterface
  {
    return (new ServerRequestFactory())
      ->createServerRequest($method, $path);
  }

  protected function app(): App
  {
    /** @var App $app */
    return $app = (require __DIR__ . '/../../config/app.php')(self::container());
  }

  private function container(): ContainerInterface
  {
    /** @var ContainerInterface $container */
    return require __DIR__ . '/../../config/container.php';
  }
}