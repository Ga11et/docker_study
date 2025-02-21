<?php

declare(strict_types=1);

namespace Test\Unit\Http;

use App\Http\JsonResponse;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonResponseTest extends TestCase
{
  public function testIntWithCode(): void
  {
    $response = new JsonResponse(12, 201);

    $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    $this->assertEquals('12', $response->getBody()->getContents());
    $this->assertEquals(201, $response->getStatusCode());
  }

  /**
   * @dataProvider getCases
   * @param mixed $source
   * @param mixed $expect
   */
  public function testResponse($source, $expect): void
  {
    $response = new JsonResponse($source);

    $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    $this->assertEquals($expect, $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function getCases(): array
  {
    $object = new stdClass();
    $object->property = 'value';
    $object->int = 12;
    $object->none = null;

    $array = [
      'property' => 'value',
      'int' => 12,
      'none' => null,
    ];

    return [
      'int' => [12, '12'],
      'none' => [null, 'null'],
      'string' => ['12', '"12"'],
      'empty' => ['', '""'],
      'object' => [$object, '{"property":"value","int":12,"none":null}'],
      'array' => [$array, '{"property":"value","int":12,"none":null}'],
    ];
  }
}