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
        $formatter = function($arr) {
            $arr['data'] = json_decode($arr['data'] ?? '{}');
            return $arr;
        };
        $batch_id = $request->getQueryParams()['batch'] ?? null;
        $filter = $batch_id ? compact('batch_id') : [];
        $data = array_map($formatter, $this->table->select($filter)->toArray());
        return new JsonResponse($data);
    }
}
