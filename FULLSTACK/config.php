<?php

    //Definindo chaves de conexão.

    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('BASE', 'servidor');

    //Conectando ao banco de dados.

    $con = new mySQLi(HOST, USER, PASS, BASE);
    