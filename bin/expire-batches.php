<?php

use App\Db\Table;

require_once __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$batchTable = $container->get(Table\Batch::class);

$maxAgeInDays = intval($argv[1] ?? 30);
if ($maxAgeInDays < 1) {
    echo "Max age parameter must be at least 1; received $maxAgeInDays.\n";
    exit(1);
}

$callback = function ($sql) use ($maxAgeInDays) {
    $relativeDate = "DATE_SUB(CURRENT_TIMESTAMP, INTERVAL $maxAgeInDays DAY)";
    $sql->where->lessThan('time', new \Laminas\Db\Sql\Expression($relativeDate));
};
$count = $batchTable->delete($callback);
echo "Deleted {$count} batch(es).\n";
exit(0);
