<?php

use App\Db\Table;
use App\MessageForwarder;

require_once __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$messageTable = $container->get(Table\Message::class);
$batchTable = $container->get(Table\Batch::class);

$messages = $messageTable->select(['batch_id' => null])->toArray();

if (count($messages) == 0) {
    echo "No messages to forward.\n";
    exit(0);
}

// If we got this far, we have messages, so let's create a batch:
$batchTable->insert(['sent' => 0]);
$batch = $batchTable->select(['id' => $batchTable->getLastInsertValue()])->toArray()[0];

$where = function ($sql) use ($messages) {
    $messageIds = array_map(
        function ($arr) {
            return $arr['id'];
        }, $messages
    );
    $sql->where->in('id', $messageIds)
        ->isNull('batch_id');
};
$count = $messageTable->update(['batch_id' => $batch['id']], $where);

// If something weird happened and we updated an unexpected number of rows, we should
// reload the messages:
if ($count != count($messages)) {
    echo "WARNING: message count mismatch; reloading data!\n";
    $messages = $messageTable->select(['batch_id' => $batch['id']])->toArray();
}

// Send the batch
$forwarder = $container->get(MessageForwarder::class);
$forwarder->forward($messages, $batch['id']);

// Mark the batch as sent
$batchTable->update(['sent' => 1], ['id' => $batch['id']]);
echo "Sent batch {$batch['id']} with {$count} messages.\n";
exit(0);
