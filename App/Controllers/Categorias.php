<?php
session_start();

use App\Core\Controller;

class Categorias extends Controller
{

    public function index()
    {

        $categoriaModel = $this->model("Categoria");

        $dados = $categoriaModel->listarTodas();

        //colocar os dados no corpo da requisição
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }

    public function find($id)
    {

        $categoriaModel = $this->model("Categoria");

        $categoriaModel = $categoriaModel->buscarPorId($id);

        if ($categoriaModel) {

            echo json_encode($categoriaModel, JSON_UNESCAPED_UNICODE);
        } else {
            //não encontrou a categoria pelo id

            http_response_code(404); //not found

            $erro = ["erro" => "Categoria não encontrada"];

            echo json_encode($erro, JSON_UNESCAPED_UNICODE);
        }
    }

    public function store()
    {

        //pegando o corpo da requisição
        $json = file_get_contents("php://input");

        //tranformando o json (string) em objeto php
        $novaCategoria = json_decode($json);

        //instanciamos o model, colocando nele a descricao recebida
        $categoriaModel = $this->model("Categoria");
        $categoriaModel->descricao = $novaCategoria->descricao;

        //chamando o inserir, que salva no banco
        $categoriaModel = $categoriaModel->inserir();

        //verificando se deu certo, e enviando a resposta apropriada
        if ($categoriaModel) {
            http_response_code(201);
            echo json_encode($categoriaModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir categoria"]);
        }
    }

    public function update($id)
    {
        //pegando o corpo da requisição
        $json = file_get_contents("php://input");

        //tranformando o json (string) em objeto php
        $categoriaEditar = json_decode($json);

        $categoriaModel = $this->model("Categoria");

        $categoriaModel = $categoriaModel->buscarPorId($id);

        //verificando se o id passado não existe, retornando erro
        if (!$categoriaModel) {
            http_response_code(404);
            echo json_encode(["erro" => "Categoria não encontrada"]);
            exit;
        }

        $categoriaModel->descricao = $categoriaEditar->descricao;

        if ($categoriaModel->atualizar()) {
            http_response_code(204);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao atualizar a categoria"]);
        }
    }

    public function delete($id)
    {

        $categoriaModel = $this->model("Categoria");

        $categoriaModel = $categoriaModel->buscarPorId($id);

        //verificando se o id passado não existe, retornando erro
        if (!$categoriaModel) {
            http_response_code(404);
            echo json_encode(["erro" => "Categoria não encontrada"]);
            exit;
        }

        //buscando a lista de produtos para a categoria 
        $produtos = $categoriaModel->getProdutos();

        //se houver produtos, retornamos um erro
        if ($produtos != []) {
            http_response_code(400);
            echo json_encode(["erro" => "Existem produtos para esta categoria, não pôde ser excluída"]);
            exit;
        }

        if ($categoriaModel->deletar()) {
            http_response_code(204);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao excluir a categoria"]);
        }
    }
}
