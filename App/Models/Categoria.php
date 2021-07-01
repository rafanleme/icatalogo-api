<?php

use App\Core\Model;

class Categoria
{

    public $id;

    public $descricao;

    public function listarTodas()
    {

        $sql = " SELECT * FROM tbl_categoria ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultados;
        } else {
            return [];
        }
    }

    public function inserir()
    {
        //declaramos o sql, com um ponto de bind ?
        $sql = " INSERT INTO tbl_categoria (descricao) VALUES (?) ";

        //preparamos a instância para inserir
        $stmt = Model::getConn()->prepare($sql);
        //substitui o primeiro ? pela variável descrição
        $stmt->bindValue(1, $this->descricao);

        //executa
        if ($stmt->execute()) {
            //se der certo, atribui o id inserido na classe
            $this->id = Model::getConn()->lastInsertId();
            //e retorna a própria classe
            return $this;
        } else {
            //se der errado, retorna falso
            return false;
        }
    }

    public function buscarPorId($id)
    {

        $sql = " SELECT * FROM tbl_categoria WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $categoria = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$categoria) {
                return false;
            }

            $this->id = $categoria->id;
            $this->descricao = $categoria->descricao;

            return $this;
        } else {
            return false;
        }
    }

    public function atualizar()
    {
        $sql = " UPDATE tbl_categoria SET descricao = ? WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->descricao);
        $stmt->bindValue(2, $this->id);

        return $stmt->execute();
    }

    public function deletar()
    {
        $sql = " DELETE FROM tbl_categoria WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->id);

        return $stmt->execute();
    }

    public function getProdutos(){

        $sql = " SELECT p.* FROM tbl_categoria c 
                INNER JOIN tbl_produto p ON p.categoria_id = c.id
                WHERE c.id = ? ";

        //preparamos a instância para inserir
        $stmt = Model::getConn()->prepare($sql);
        //substitui o primeiro ? pela variável descrição
        $stmt->bindValue(1, $this->id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultados;
        } else {
            return [];
        }
    }
}
