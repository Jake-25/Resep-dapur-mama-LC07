<?php
    require "../Config/database.php";
    
    $db = new mysqli(
        $config["server"],
        $config["username"],
        $config["password"],
        $config["database"]
    );