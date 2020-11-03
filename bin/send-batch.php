<?php
/**
 * Console tool to create and send a new batch of messages.
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2020.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuOwma
 * @package  Console
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
use App\Db\Table;
use App\MessageForwarder;

require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../config/container.php';

$messageTable = $container->get(Table\Message::class);
$batchTable = $container->get(Table\Batch::class);

// Let's check for failed batches from prior runs:
$unsentBatches = array_map(
    function ($batch) {
        return $batch['id'];
    }, $batchTable->select(['sent' => 0])->toArray()
);

$messages = $messageTable->select(['batch_id' => null])->toArray();

if (count($messages) == 0) {
    // No messages to send? Set up an empty placeholder batch in case we still
    // need to resend failed batches:
    $batch = null;
} else {
    // If we got this far, we have messages, so let's create a batch:
    $batchTable->insert(['sent' => 0]);
    $batch = $batchTable->select(
        ['id' => $batchTable->getLastInsertValue()]
    )->toArray()[0];

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

    // If something weird happened and we updated an unexpected number of rows,
    // we should reload the messages:
    if ($count != count($messages)) {
        echo "WARNING: message count mismatch; reloading data!\n";
        $messages = $messageTable->select(['batch_id' => $batch['id']])->toArray();
    }
}

// Send the batch
$forwarder = $container->get(MessageForwarder::class);
$forwarder->forward($messages, $batch['id'] ?? null, $unsentBatches);

// Mark the batch as sent
$sentBatches = $unsentBatches;
if (isset($batch['id'])) {
    $sentBatches[] = $batch['id'];
}
$updateCallback = function ($sql) use ($sentBatches) {
    $sql->where->in('id', $sentBatches);
};
$batchTable->update(['sent' => 1], $updateCallback);
if (!empty($unsentBatches)) {
    echo "Resent failed batch(es): " . implode(', ', $unsentBatches) . "\n";
}
if (isset($batch['id'])) {
    echo "Sent batch {$batch['id']} with {$count} message(s).\n";
} else {
    echo "No new messages to send.\n";
}
exit(0);
