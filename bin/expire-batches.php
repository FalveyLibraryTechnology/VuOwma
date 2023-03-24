<?php

/**
 * Console tool to expire old batches from the database.
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
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

$container = include __DIR__ . '/../config/container.php';

$entityManager = $container->get(EntityManager::class);

$maxAgeInDays = intval($argv[1] ?? 30);
if ($maxAgeInDays < 1) {
    echo "Max age parameter must be at least 1; received $maxAgeInDays.\n";
    exit(1);
}

$queryBuilder = $entityManager->createQueryBuilder();
$queryBuilder->delete(Batch::class, 'b');
$queryBuilder->where('b.time < :time');
$queryBuilder->setParameter('time', new \DateTime("now - $maxAgeInDays days"));
$query = $queryBuilder->getQuery();
$count = $query->getResult();

echo "Deleted {$count} batch(es).\n";

exit(0);
