<?php

use app\core\Application;

class m01_initial
{
    public function up()
    {
        $db = Application::$app->DB;

        $SQLSTMT = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
            ENGINE=INNODB;";

        $db->pdo->exec($SQLSTMT);
    }

    public function down()
    {
        
        $db = Application::$app->DB;

        $SQLSTMT = "DROP TABLE users;";

        $db->pdo->exec($SQLSTMT);
    }
    
}
