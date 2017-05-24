<?php
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;

    $isDevMode = true;
    $config = Setup::createAnnotationMetadataConfiguration(array($_SERVER['DOCUMENT_ROOT']."/src/entities"), $isDevMode);

    $connParams = array(
        'dbname' => 'mydb',
        'user' => getenv('urlshortener_db_user'),
        'password' => getenv('urlshortener_db_password'),
        'host' => 'localhost',
        'driver' => 'pdo_mysql'
    );

    $conn = \Doctrine\DBAL\DriverManager::getConnection($connParams, $config);
    $entityManager = EntityManager::create($conn, $config);