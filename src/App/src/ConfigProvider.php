<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories' => [
                Db\Table\Batch::class => Db\Table\TableFactory::class,
                Db\Table\Message::class => Db\Table\TableFactory::class,
                Handler\GetMessageHandler::class => Handler\MessageAwareFactory::class,
                Handler\SaveMessageHandler::class => Handler\MessageAwareFactory::class,
            ],
            'invokables' => [
                Handler\TooManyHandler::class => Handler\TooManyHandler::class,
            ],
        ];
    }
}
