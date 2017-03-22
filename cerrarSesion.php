<?php
    include_once 'lib.php';
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
       
    User::logout();
    header('Location: index.php');
