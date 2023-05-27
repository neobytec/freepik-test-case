<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Handler\PingHandler;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;
use function json_decode;
use function property_exists;
use const JSON_THROW_ON_ERROR;

class PingHandlerTest extends TestCase
{
    public function testResponse(): void
    {
        $pingHandler = new PingHandler();
        $response    = $pingHandler->handle(
            $this->createMock(ServerRequestInterface::class)
        );

        /** @var stdClass $json */
        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(property_exists($json, 'ack') && $json->ack !== null);
    }
}
