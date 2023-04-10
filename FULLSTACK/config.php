<?php

    //Definindo chaves de conexão.

    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('BASE', 'servidor');

    //Conectando ao banco de dados.

    $con = new mySQLi(HOST, USER, PASS, BASE);
    $sql = "CREATE TABLE IF NOT EXISTS niveis (Id int(11) AUTO_INCREMENT, Nivel varchar(100), PRIMARY KEY (Id))";
    $sql2 = "CREATE TABLE IF NOT EXISTS desenvolvedores (Id int(11) AUTO_INCREMENT, Nivel_Id int(11), Nome varchar(100), DataNascimento date, Sexo char(2), Hobby varchar(100), PRIMARY KEY (Id), FOREIGN KEY (Nivel_Id) REFERENCES niveis(Id))";


    mysqli_query($con, $sql);
    mysqli_query($con, $sql2);
    
