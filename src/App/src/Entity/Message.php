<?php
/**
 * Message entity class
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

use Doctrine\ORM\Mapping as ORM;

/**
 * Message entity class
 *
 * @category VuOwma
 * @package  Database
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 *
 * @ORM\Entity
 * @ORM\Table(name="messages")
 */
class Message
{
    /**
     * ID
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Time
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $time;

    /**
     * Message data
     *
     * @var string|null
     *
     * @ORM\Column(type="text")
     */
    protected $data;

    /**
     * Associated batch
     *
     * @var Batch
     *
     * @ORM\ManyToOne(targetEntity="Batch", inversedBy="messages")
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
     * @return Message
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
     * @return Message
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
     * @param Batch|null $batch Batch to set
     *
     * @return Message
     */
    public function setBatch(Batch $batch = null)
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * Get batch.
     *
     * @return Batch|null
     */
    public function getBatch()
    {
        return $this->batch;
    }
}
