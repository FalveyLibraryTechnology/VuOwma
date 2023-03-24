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

use App\Entity\Batch;
use App\Entity\Message;
use App\MessageForwarder;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../config/container.php';

$entityManager = $container->get(EntityManager::class);

// Let's check for failed batches from prior runs:
$batchRepository = $entityManager->getRepository(Batch::class);
$unsentBatches = $batchRepository->findBy(['sent' => false]);
$unsentBatchIds = array_map(
    function ($batch) {
        return $batch->getId();
    },
    $unsentBatches
);

$msgRepository = $entityManager->getRepository(Message::class);
$messages = $msgRepository->findBy(['batch' => null]);

if (count($messages) == 0) {
    // No messages to send? Set up an empty placeholder batch in case we still
    // need to resend failed batches:
    $batchId = null;
} else {
    // If we got this far, we have messages, so let's create a batch:
    $batch = new Batch();
    $entityManager->persist($batch);
    $entityManager->flush();
    $batchId = $batch->getId();

    foreach ($messages as $message) {
        $message->setBatch($batch);
        $entityManager->persist($message);
    }
    $entityManager->flush();
}

// Send the batch
$forwarder = $container->get(MessageForwarder::class);
$forwarder->forward($messages, $batchId, $unsentBatchIds);

// Mark the batch as sent
if (!empty($batch)) {
    $batch->setSent(true);
    $entityManager->persist($batch);
}
if (!empty($unsentBatches)) {
    foreach ($unsentBatches as $unsentBatch) {
        $unsentBatch->setSent(true);
        $entityManager->persist($unsentBatch);
    }
    echo "Resent failed batch(es): " . implode(', ', $unsentBatchIds) . "\n";
}
$entityManager->flush();
$count = count($messages);
echo isset($batchId)
    ? "Sent batch {$batchId} with {$count} message(s).\n"
    : "No new messages to send.\n";
exit(0);
