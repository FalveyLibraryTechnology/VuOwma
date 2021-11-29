<?php
/**
 * Batches entity class
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
 * @package  Database
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
namespace App\Entity;

/**
 * Batches entity class
 *
 * @category VuOwma
 * @package  Database
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
class Batches
{
    /**
     * ID
     *
     * @var int
     */
    protected $id;

    /**
     * Time
     *
     * @var \DateTime
     */
    protected $time;

    /**
     * Sent status
     *
     * @var bool|null
     */
    protected $sent = '0';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setTime(new \DateTime());
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set time.
     *
     * @param \DateTime $time Time to set
     *
     * @return Batches
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set sent.
     *
     * @param bool|null $sent Was the batch sent?
     *
     * @return Batches
     */
    public function setSent($sent = null)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent.
     *
     * @return bool|null
     */
    public function getSent()
    {
        return $this->sent;
    }
}
