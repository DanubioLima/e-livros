<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Controller\Pages\Page;

class About extends Page {

    /**
     * método que retorna o conteúdo da página about.
     *
     * @return string
     */
    public static function getAbout(){
        //conteudo da página home
        $content = View::render('pages/about', [
            'name' => 'Danubio Lima',
            'description' => 'projeto mvc'
        ]);

        //retorna a view com os dados
        return parent::getPage('E-livros - Sobre', $content);
    }
}