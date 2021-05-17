<?php

use \App\Controller\Pages;
use \App\Http\Response;


//define a pagina home
$obRouter->get('/',[
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);

//define a pagina sobre
$obRouter->get('/sobre',[
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);

//define a pagina de confirmar a exclusão de um livro
$obRouter->get('/delete/{id}',[
    function($id){
        return new Response(200, Pages\BookDelete::getBook($id));
    }
]);

//define a pagina de confirmar a exclusão de um livro (form POST)
$obRouter->post('/delete/{id}',[
    function($id){
        return new Response(200, Pages\BookDelete::deleteBook($id));
    }
]);

//define a pagina de editar
$obRouter->get('/edit/{id}',[
    function($id){
        return new Response(200, Pages\BookEdit::getBook($id));
    }
]);

//define a página de editar (form POST)
$obRouter->post('/edit/{id}',[
    function($id, $request){
        return new Response(200, Pages\BookEdit::editBook($id, $request));
    }
]);

//define a pagina de livros
$obRouter->get('/books',[
    function(){
        return new Response(200, Pages\Book::getBooks());
    }
]);

//define a pagina de livros (form POST)
$obRouter->post('/books',[
    function($request){
        return new Response(200, Pages\Book::insertBooks($request));
    }
]);


//define uma página dinâmica
$obRouter->get('/pagina/{idPagina}',[
    function($idPagina){
        return new Response(200, 'Página '.$idPagina);
    }
]);