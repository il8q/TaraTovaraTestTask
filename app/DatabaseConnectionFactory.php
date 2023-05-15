<?php

namespace App;

use Exception;
use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;

class DatabaseConnectionFactory
{
    private static ?Mysql $instance = null;

    /**
     * @throws Exception
     */
    public static function create(): Mysql
    {
        $pdo = new PDOConnector(
            'localhost',
            'root',
            '',
            'tara_tovara'
        );
        $pdoConn = $pdo->connect('utf8', []);

        if (self::$instance === null) {
            self::$instance = new Mysql($pdoConn);
        }
        return self::$instance;
    }
}