<?php
namespace App\Lib;

use PDO;
use App\Config\ConfigGlobal;

class Database
{
    public static function StartUp()
    {
        $config = new ConfigGlobal();
        $db = $config->getDb();
        $pdo = new PDO('mysql:host=localhost;dbname='.$db['dbname'].';charset=utf8', $db['dbuser'], $db['dbpassword']);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        
        return $pdo;
    }
}