<?php

use app\core\Application;

class m02_add_password_column
{
    public function up()
    {
        $db = Application::$app->DB;

        $SQLSTMT = "ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL";

        $db->pdo->exec($SQLSTMT);
    }

    public function down()
    {
        
        $db = Application::$app->DB;

        $SQLSTMT = "ALTER TABLE users DROP COLUMN password";

        $db->pdo->exec($SQLSTMT);
    }
    
}
