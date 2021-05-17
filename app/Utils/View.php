<?php

namespace App\Utils;

// echo "<pre>";
// print_r($vars);
// echo "</pre>"; exit;

class View {

    /**
     * variáveis padrões da View
     *
     * @var array
     */
    private static $vars = [];

    /**
     * metódo que define os dados inicias da classe
     *
     * @param  array  $vars
     *
     */
    public static function init($vars = []){
        self::$vars = $vars;
    }

    /**
     * 
     * metódo que retorna o conteúdo estático da view
     *
     * @param  string  $view
     *
     * @return string
     */
    private static function getContentView($view){
        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * método que retorna o conteúdo dinâmico de uma view
     *
     * @param  string  $view 
     * @param  array   $vars
     *
     * @return string
     */
    public static function render($view, $vars = []){
        //conteúdo da view
        $contentView = self::getContentView($view);

        // unir variáveis da view
        $vars = array_merge(self::$vars, $vars);

        //chaves do array de variaveis
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        }, $keys);
    
        //retorna o conteúdo renderizado
        return str_replace($keys, array_values($vars), $contentView);
    }
}