<?php

namespace App\Db\Table;

use Laminas\Db\Adapter\Adapter;

class Message extends \Laminas\Db\TableGateway\TableGateway
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('messages', $adapter);
    }
}
