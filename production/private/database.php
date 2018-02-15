    <?php

    require_once ('database-config.inc.php');

    function db_connect() {
        $connection = mysqli_connect(DB_HOST, DB_USER´, DB_PASS, DB_NAME);
        return $connection;
    }

    function db_disconnect($connection) {
        if (isset($connection)) {
            mysqli_close($connection);
        }
    }

    ?>