<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Http;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;



class HomeAction
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) {
    return Http::json($response, new stdClass());
  }
}
