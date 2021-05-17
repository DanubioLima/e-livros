<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Book {
    /**
     * identificador único do livro
     *
     * @var integer
     */
    public $id;

    /**
     * nome do livro
     *
     * @var string
     */
    public $nome;

    /**
     * autor do livro
     *
     * @var string
     */
    public $autor;

    /**
     * comentário sobre o livro
     *
     * @var string
     */
    public $comentario;

    /**
     * nome da imagem salva no upload
     *
     * @var string
     */
    public $imagem;

    /**
     * metódo que cadastra um livro no banco
     *
     * @return boolean
     */
    public function cadastrar(){
       //preenche o id e insere um livro no banco
       
       $this->id = (new Database('livros'))->insert([
           'nome'       => $this->nome,
           'autor'      => $this->autor,
           'comentario' => $this->comentario,
           'imagem'     => $this->imagem
       ]);

       //retorna sucesso
       return true;
    }

    /**
     * metódo que remove um livro
     * @param integer $id
     * 
     * @return  boolean
     */
    public function deletar($id){
        //executa a exclusão
        $success = (new Database('livros'))->delete('id = '.$id);

        //retorna o resultado(true/false)
        return $success;
    }

    public function atualizar($id){
        //executa a atualização
        $success = (new Database('livros'))->update('id = '.$id, [
            'nome'       => $this->nome,
            'autor'      => $this->autor,
            'comentario' => $this->comentario,
            'imagem'     => $this->imagem
        ]);

        return $success;
    }

    /**
     * método que retorna os livros
     *
     * @param   string  $where  
     * @param   string  $order   
     * @param   string  $limit   
     * @param   string  $fields  
     *
     * @return  PDOStatement          
     */
    public static function getBooks($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('livros'))->select($where, $order, $limit, $fields);
    }
}