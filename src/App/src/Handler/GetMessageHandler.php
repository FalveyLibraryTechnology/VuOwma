<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Table\Message;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetMessageHandler implements RequestHandlerInterface
{
    protected $table;

    public function __construct(Message $table)
    {
        $this->table = $table;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = $this->table->select()->toArray();
        return new JsonResponse($data);
    }
}
