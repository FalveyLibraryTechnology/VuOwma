<?php

/**
 * Handler for "get messages" action.
 *
 * PHP version 8
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
 * @package  Handlers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Message;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Handler for "get messages" action.
 *
 * @category VuOwma
 * @package  Handlers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
class GetMessageHandler implements RequestHandlerInterface
{
    /**
     * Entity manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager Entity manager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Handler for action
     *
     * @param ServerRequestInterface $request Server request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $formatter = function ($msg) {
            $batch = $msg->getBatch();
            return [
                'id' => intval($msg->getId()),
                'time' => $msg->getTime()->format('Y-m-d H:i:s'),
                'data' => json_decode($msg->getData() ?? '{}'),
                'batch_id' => $batch ? intval($batch->getId()) : null,
            ];
        };
        $batch_id = $request->getQueryParams()['batch'] ?? null;
        $filter = ['batch' => $batch_id ? $batch_id : null];
        $repository = $this->entityManager->getRepository(Message::class);
        $data = array_map($formatter, $repository->findBy($filter));
        return new JsonResponse($data);
    }
}
