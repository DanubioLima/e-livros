<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\UploadImage;
use \App\Controller\Pages\Page;
use \App\Model\Entity\Book as EntityBook;

class Book extends Page {
    /**
     * método que retorna o conteúdo da página de livros
     *
     * @return string
     */
    public static function getBooks(){
        //conteudo da página home
        $content = View::render('pages/books', []);

        //retorna a view com os dados
        return parent::getPage('E-livros - Cadastro', $content);
    }

    /**
     * 
     *
     * @param  Request  $request
     *
     * @return void
     */
    public static function insertBooks($request){
        //dados do post vindo do form
        $postVars = $request->getPostVars();
        $fileVars = $request->getFileVars();
        $obImage  = new UploadImage($fileVars['imagem']);

        //faz upload da imagem
        $obImage->upload(__DIR__.'/../../../files');
    
        //instância de book
        $obBook = new EntityBook;

        //preencher os dados da classe e chama o cadastro
        $obBook->nome       = $postVars['nome'];
        $obBook->autor      = $postVars['autor'];
        $obBook->comentario = $postVars['comentario'];
        $obBook->imagem     = $obImage->getBasename();

        $obBook->cadastrar();

        //emite alerta na tela
        echo "<script>alert('Livro adicionado com sucesso!');</script>";

        return self::getBooks();
    }
}