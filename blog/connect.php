<?php
    session_start();

    global $connect;
    
    DEFINE("ENVIRONMENT", "development");

    $config = array();

    if(ENVIRONMENT == 'development'){
        $config['type'] = "mysql";
        $config['name'] = "blog";
        $config["host"] = "localhost:8080";
        $config['user'] = 'root';
        $config['pass'] = '';
    }else{
        $config['type'] = "mysql";
        $config["host"] = "localhost:8080";
        $config['user'] = 'root';
        $config['pass'] = 'root';
    }

    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try{
        $connect = new PDO($config['type'].":dbname=".$config['name'], $config['user'], $config['pass'], $options);
    }catch(PDOException $e){
        echo "ERRO".$e->getMessage();
    }
?>