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
