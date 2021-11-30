<?php
/**
 * The configuration provider for the App module
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
 * @package  Config
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 * @see      https://docs.laminas.dev/laminas-component-installer/
 */
declare(strict_types=1);
namespace App;

use App\Doctrine\AnnotationDriverFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

/**
 * The configuration provider for the App module
 *
 * @category VuOwma
 * @package  Config
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/FalveyLibraryTechnology/VuOwma/
 * @see      https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies() : array
    {
        return [
            'aliases' => [
                'doctrine.entity_manager.orm_default' => EntityManager::class,
                'doctrine.driver.orm_default' => AnnotationDriver::class,
            ],
            'factories' => [
                AnnotationDriver::class => AnnotationDriverFactory::class,
                EntityManager::class => EntityManagerFactory::class,
                Handler\GetMessageHandler::class =>
                    Handler\DoctrineAwareFactory::class,
                Handler\SaveMessageHandler::class =>
                    Handler\DoctrineAwareFactory::class,
                MessageForwarder::class => MessageForwarderFactory::class,
            ],
            'invokables' => [
                Handler\TooManyHandler::class => Handler\TooManyHandler::class,
            ],
        ];
    }
}
