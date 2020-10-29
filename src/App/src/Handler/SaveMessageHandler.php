<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Table\Message;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SaveMessageHandler implements RequestHandlerInterface
{
    protected $table;

    public function __construct(Message $table)
    {
        $this->table = $table;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $success = $this->table->insert(['data' => $request->getBody()]);
        return new JsonResponse(compact('success'));
    }
}
