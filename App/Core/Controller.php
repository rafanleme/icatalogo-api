<?php

namespace App\Core;

class Controller{

    //recebe o model que vai ser utilizado pelo controller
    //instancia e retorna a intância pronta para o uso
    public function model($model){
        require_once "../App/Models/" . $model . ".php";
        return new $model;
    }

    //recebe a view que vai ser renderizada e passa para o template
    //passa também os dados para a view
    public function view($view, $data = []){
        require_once "../App/Views/template.php";
    }

}