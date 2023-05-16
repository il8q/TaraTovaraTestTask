<?php

namespace App\Database;

use Exception;
use PDO;
use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;

class DatabaseConnectionFactory
{
    private static ?Mysql $mysql = null;
    private static ?PDO $pdoConnection = null;

    /**
     * @throws Exception
     */
    public static function create(): Mysql
    {
        if (self::$mysql === null) {
            self::$mysql = new Mysql(self::createPdoConnection());
        }
        return self::$mysql;
    }

    /**
     * @throws Exception
     */
    public static function createPdoConnection(): ?PDO
    {
        if (self::$pdoConnection === null) {
            $pdo = new PDOConnector(
                'localhost',
                'root',
                '',
                'tara_tovara'
            );
            self::$pdoConnection = $pdo->connect();
        }
        return self::$pdoConnection;
    }
}