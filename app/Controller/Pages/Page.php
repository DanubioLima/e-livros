<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page {

    /**
     * metódo que retorna o topo da página(header)
     *
     * @return  string
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

    /**
     * metódo que retorna o rodapé da página(footer)
     *
     * @return  string
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }

    /**
     * método que retorna o conteúdo do template padrão
     *
     * @return string
     */
    public static function getPage($title, $content){
        return View::render('pages/page', [
            'title'   => $title,
            'header'  => self::getHeader(),
            'content' => $content,
            'footer'  => self::getFooter()
        ]);
    }
}