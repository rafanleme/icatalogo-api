<?php

//o namespace deve sempre corresponder a estrutura de pasta que a classe se encontra
namespace App\Core;

class Model {

    //utilizando o padrão de projeto singleton
    private static $conexao;

    public static function getConn(){

        //se a conexão não estiver aberta, criamos
        if(!isset(self::$conexao)){
            self::$conexao = new \PDO("mysql:host=localhost;port=3306;dbname=icatalogo;", "root", "bcd127");
        }

        //retornamos a conexão
        return self::$conexao;
    }

}