<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            'doctrine.entity_manager.orm_default' => EntityManager::class,
            'doctrine.driver.orm_default' => AnnotationDriver::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            AnnotationDriver::class => \App\Doctrine\AnnotationDriverFactory::class,
            EntityManager::class => EntityManagerFactory::class,
        ],
    ],
];
