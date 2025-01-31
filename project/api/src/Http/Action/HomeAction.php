<?php

declare(strict_types=1);

namespace App\Http\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $response->getBody()->write('{ "message": "Hello world" }');
    return $response->withHeader('Content-Type', 'application/json');
  }
}
