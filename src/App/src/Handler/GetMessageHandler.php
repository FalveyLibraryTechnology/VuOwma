<?php
/**
 * Handler for "get messages" action.
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
 * @package  Handlers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
declare(strict_types=1);
namespace App\Handler;

use App\Db\Table\Message;
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
     * Message table gateway
     *
     * @var Message
     */
    protected $table;

    /**
     * Constructor
     *
     * @param Message $table Message table gateway
     */
    public function __construct(Message $table)
    {
        $this->table = $table;
    }

    /**
     * Handler for action
     *
     * @param ServerRequestInterface $request Server request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $formatter = function ($arr) {
            $arr['data'] = json_decode($arr['data'] ?? '{}');
            return $arr;
        };
        $batch_id = $request->getQueryParams()['batch'] ?? null;
        $filter = $batch_id ? compact('batch_id') : ['batch_id' => null];
        $data = array_map($formatter, $this->table->select($filter)->toArray());
        return new JsonResponse($data);
    }
}
