<?php
$container = require __DIR__ . '/config/container.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
    $container->get('doctrine.entity_manager.orm_default')
);
