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

  public function testNull(): void
  {
    $response = new JsonResponse(null);

    $this->assertEquals('null', $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testInt(): void
  {
    $response = new JsonResponse(12);

    $this->assertEquals('12', $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testString(): void
  {
    $response = new JsonResponse('12');

    $this->assertEquals('"12"', $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testObject(): void
  {
    $object = new stdClass();
    $object->property = 'value';
    $object->int = 12;
    $object->none = null;


    $response = new JsonResponse($object);

    $this->assertEquals('{"property":"value","int":12,"none":null}', $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testArray(): void
  {
    $array = [
      'property' => 'value',
      'int' => 12,
      'none' => null,
    ];

    $response = new JsonResponse($array);

    $this->assertEquals('{"property":"value","int":12,"none":null}', $response->getBody()->getContents());
    $this->assertEquals(200, $response->getStatusCode());
  }
}