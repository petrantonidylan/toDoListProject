<?php
    require_once('../.env');

    define("DB_DRIVER", "sqlsrv");
    define("DB_HOST", "localhost");
    define("DB_USER", getenv('DATABASE_USER'));
    define("DB_PASS", getenv('DATABASE_PASSWORD'));
    define("DB_DATABASE", getenv('DATABASE_NAME'));
    define("DB_CHARSET", "utf8");
?>