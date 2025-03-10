<?php

declare(strict_types=1);

namespace Test\Functional;

class HomeTest extends WebTestCase
{
  public function testSuccess(): void
  {
    $response = $this->app()->handle(self::json('GET', '/'));

    $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    self::assertEquals(200, $response->getStatusCode());
    self::assertEquals('{}', (string) $response->getBody());
  }
}