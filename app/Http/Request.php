<?php

namespace App\Http;

class Request {
    /**
     * metódo http da requisição
     *
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     *
     * @var string
     */
    private $uri;

    /**
     * parâmetros da url
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * variáveis recebidas no post
     *
     * @var array
     */
    private $postVars = [];

    /**
     * arquivos recebidos via post
     *
     * @var array
     */
    private $fileVars = [];

    /**
     * 
     * os headers(cabeçalho) da requisição
     * @var array
     */
    private $headers = [];

    /**
     * construtor da classe
     *
     */
    public function __construct(){
        $this->queryParams = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->fileVars    = $_FILES ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri         = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * metódo que retorna a uri da requisição
     *
     * @return  string
     */
    public function getUri(){
        return $this->uri;
    }

    /** 
     * metódo que retorna os headers da requisição
     *
     * @return  array
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * metódo que retorna o metódo http da requisição
     *
     * @return  string
     */
    public function getHttpMethod(){
        return $this->httpMethod;
    }

    /**
     * metódo que retorna os params da requisição
     *
     * @return  array
     */
    public function getQueryParams(){
        return $this->queryParams;
    }

    /**
     * metódo que retorna as variaveis post da requisição
     *
     * @return  array
     */
    public function getPostVars(){
        return $this->postVars;
    }

    /**
     * metódo que retorna as variaveis com arquivos da requisição
     *
     * @return  array
     */
    public function getFileVars(){
        return $this->fileVars;
    }
}