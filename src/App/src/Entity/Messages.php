<?php
/**
 * Messages entity class
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
 * Messages entity class
 *
 * @category VuOwma
 * @package  Database
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 */
class Messages
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
     * Message data
     *
     * @var string|null
     */
    protected $data;

    /**
     * Associated batch
     *
     * @var Batches
     */
    protected $batch;

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
     * @return Messages
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
     * Set data.
     *
     * @param string|null $data Data to set
     *
     * @return Messages
     */
    public function setData($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data.
     *
     * @return string|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set batch.
     *
     * @param Batches|null $batch Batch to set
     *
     * @return Messages
     */
    public function setBatch(Batches $batch = null)
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * Get batch.
     *
     * @return Batches|null
     */
    public function getBatch()
    {
        return $this->batch;
    }
}
