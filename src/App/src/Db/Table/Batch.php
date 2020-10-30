<?php

namespace App\Db\Table;

use Laminas\Db\Adapter\Adapter;

class Batch extends \Laminas\Db\TableGateway\TableGateway
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('batches', $adapter);
    }
}
