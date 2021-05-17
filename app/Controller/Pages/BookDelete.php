<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Controller\Pages\Page;
use \App\Model\Entity\Book;

class BookDelete extends Page {


    /**
     * metódo que chama a exclusão do livro
     *
     * @param   integer  $id       [$id description]
     * @param   [type]  $request  [$request description]
     *
     */
    public static function deleteBook($id){
       $obBook  = new Book;
       $success = $obBook->deletar($id);
       if($success){
           header('Location: '.URL);
           exit;
       } else {
           echo "Houve um erro";
       }
    }


    /**
     * metódo que pega os dados de um livros
     * @param integer $id
     * 
     * @return string
     */
    private static function getBookData($id){
        //busca um livro pelo id
        $book = Book::getBooks('id = '.$id)->fetchObject(Book::class);

        //retorna esse livro
        return $book;
    }

    /**
     * 
     *
     * @param  integer  $request
     *
     * @return string
     */
    public static function getBook($id){
        $livro = self::getBookData($id);
        
        $content = View::render('pages/delete', [
            'id' => $id,
            'nome' => $livro->nome
        ]);

        return parent::getPage('E-livros - Excluir', $content);
    }
}