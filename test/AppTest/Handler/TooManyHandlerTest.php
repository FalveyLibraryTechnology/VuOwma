<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\TooManyHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

use function get_class;

class TooManyHandlerTest extends TestCase
{
    public function testReturnsJsonResponse()
    {
        $handler = new TooManyHandler();
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $response = $handler->handle($request);
        $this->assertEquals(['simulated_429_error' => true], $response->getPayload());
        $this->assertEquals(429, $response->getStatusCode());
    }
}
