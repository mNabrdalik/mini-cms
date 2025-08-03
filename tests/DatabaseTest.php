<?php

use PHPUnit\Framework\TestCase;
use MiniCMS\Database\Database;

class DatabaseTest extends TestCase
{
    // Verify that only one instance is created (singleton behavior).
    public function testGetInstanceReturnsSameObject()
    {
        $db1 = Database::getInstance('localhost', 'testdb', 'user', 'pass');
        $db2 = Database::getInstance('localhost', 'testdb', 'user', 'pass');

        $this->assertSame($db1, $db2);
    }

    //Check if getConnection() returns a valid PDO instance
    public function testGetConnectionReturnsPDO()
    {
        $db = Database::getInstance('localhost', 'testdb', 'user', 'pass');
        $connection = $db->getConnection();

        $this->assertInstanceOf(PDO::class, $connection);
    }
}
