<?php

namespace App\Http;

class Response {
    /**
     * código do status http da response
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * cabeçalho da response
     *
     * @var array
     */
    private $headers = [];

    /**
     * tipo de conteúdo que está sendo retornado
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * o conteúdo do response
     * @var mixed
     */
    private $content;

    /**
     * construtor da classe
     *
     * @param   integer  $httpCode     [$httpCode description]
     * @param   mixed  $content      [$content description]
     * @param   string  $contentType  [$contentType description]
     *
     */
    public function __construct($httpCode, $content, $contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->setContentType($contentType);
    }

    /**
     * metódo que envia os headers para o navegador
     *
     */
    private function sendHeaders(){
        //definir status
        http_response_code($this->httpCode);

        //enviar headers
        foreach ($this->headers as $key => $value) {
           header($key.': '.$value); 
        }
    }

    /**
     * metódo que altera o content type do response
     *
     * @param   string  $contentType  
     */
    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * metódo que adiciona registro no header da response
     * @param   string  $key    
     * @param   string   $value  
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }

    /**
     * metódo que envia a resposta ao usuário
     *
     */
    public function sendResponse(){
        //envia os headers
        $this->sendHeaders();

        //imprime o conteúdo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
            
        }
    }
}