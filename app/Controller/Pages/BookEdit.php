<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\UploadImage;
use \App\Controller\Pages\Page;
use \App\Model\Entity\Book;

class BookEdit extends Page {

    /**
     * metódo que chama a exclusão do livro
     *
     * @param   Request $request
     *
     */
    public static function editBook($id, $request){
        error_reporting(E_ALL);
        ini_set('display_errors', true);
       //pega os dados do form
       $postVars    = $request->getPostVars();
       $fileVars    = $request->getFileVars();
       $statusImage = $fileVars['imagem']['error'];

       //pega o livro atual 
       $currentBook = self::getBookData($id);

       //instancia a classe de upload
       $obImagem    = new UploadImage($fileVars['imagem']);

       //nome da imagem a ser enviada
       $imageToSend = '';

       //verifica se o usuário atualizou a imagem
       if($statusImage != 4){
          $obImagem->upload(__DIR__.'/../../../files');
          $imageToSend  = $obImagem->getBasename();
       } else {
           $imageToSend = $currentBook->imagem;
       }

       //preenche a classe com os novos dados
       $obBook = new Book;        
       $obBook->nome       = $postVars['nome'];
       $obBook->autor      = $postVars['autor'];
       $obBook->comentario = $postVars['comentario'];
       $obBook->imagem     = $imageToSend;

       //atualiza o livro
       $success = $obBook->atualizar($id);
       if($success){
           echo  "
           <script>
             alert('Alteração feita com sucesso!');
             window.location = '/crud-books';
           </script>";
           
       } else {
           echo "Houve um erro";
       }
    }


    /**
     * metódo que pega os dados de um livros
     * @param integer $id
     * 
     * @return Book
     */
    private static function getBookData($id){
        //busca um livro pelo id
        $book = Book::getBooks('id = '.$id)->fetchObject(Book::class);

        //retorna o livro
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
        
        $content = View::render('pages/edit', [
            'id'         => $livro->id,
            'nome'       => $livro->nome,
            'autor'      => $livro->autor,
            'comentario' => $livro->comentario,
            'imagem'     => $livro->imagem
        ]);

        return parent::getPage('E-livros - Editar', $content);
    }
}