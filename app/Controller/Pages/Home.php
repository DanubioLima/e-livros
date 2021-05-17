<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Controller\Pages\Page;
use \App\Model\Entity\Book;

class Home extends Page {

    private static function getBookItems(){
        $itens = '';

        //obtem a lista de resultados
        $results = Book::getBooks(null, 'id DESC');

        //cria a string a ser renderizada
        while ($obBook = $results->fetchObject(Book::class)) {
            $itens .= View::render('pages/book/item', [
                'id'         => $obBook->id,
                'nome'       => $obBook->nome,
                'autor'      => $obBook->autor,
                'comentario' => $obBook->comentario,
                'imagem'     => $obBook->imagem,
            ]);                                                        
        }

        return $itens;
    }

    /**
     * método que retorna o conteúdo da página home.
     *
     * @return string
     */
    public static function getHome(){
        //conteudo da página home
        $content = View::render('pages/home', [
            'items' => self::getBookItems()
        ]);

        //retorna a view com os dados
        return parent::getPage('E-livros', $content);
    }
}