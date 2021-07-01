<?php

use App\Core\Controller;

class Produtos extends Controller{

    //lista todos os produtos
    public function index(){

        $produtoModel = $this->model("Produto");

        $dados = $produtoModel->listarTodos();

        $this->view("produtos/index", $dados);
    }

    public function inserir(){

        //$_POST

        //validar os campos

        //criar no model o método que insere no banco

        //pesquisar sobre insert com PDO

        //chamar o insert no model

        //verificar se deu certo

        //se sim, devolve a view de categorias index

        //pode também colocar uma mensagem na session


    }

    private function validarCampos(){

    }

}