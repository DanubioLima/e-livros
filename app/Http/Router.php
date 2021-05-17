<?php

namespace App\Http;

use \Closure;
use \Exception;
use \App\Http\Response;
use \ReflectionFunction;

class Router {
    /**
     * url completa
     *
     * @var string
     */
    private $url = '';

    /**
     * prefixo comum a todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * índice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * instância de request
     *
     * @var Request
     */
    private $request;

    /**
     * construtor da classe
     *
     * @param   string  $url 
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * metódo que define o prefixo das rotas
     *
     */
    private function setPrefix(){
        //pega informações da url atual
        $parse        = parse_url($this->url);

        //define o prefixo
        $this->prefix = $parse['path'] ?? '';
    }

    /**
     * método que adiciona uma rota na classe
     *
     * @param   string  $method  
     * @param   string  $route   
     * @param   array  $params
     */
    private function addRoute($method, $route, $params){
        //validar os parâmetros
        foreach ($params as $key => $value) {
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }

        }

        //variáveis das rotas
        $params['variables'] = [];

        //regex para validar as variáveis nas rotas
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //padrão de validação da url
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

        //adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * metódo que executa a rota atual
     *
     *@return Response
     */
    public function run(){
        try {
            //obtém a rota atual
            $route = $this->getRoute();

            //verifica se existe o controlador
            if(!isset($route['controller'])){
                throw new Exception('Erro', 500);
            }

            //argumentos da função
            $args = [];

            //reflection
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //retorna a execução da função
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $er) {
            return new Response($er->getCode(), $er->getMessage());
        }
    }

    /**
     * metódo que retorna os dados da rota atual
     *
     * @return  array
     */
    private function getRoute(){
        //uri sem prefixo
        $uri = $this->getUri();

        //metódo http usado na request
        $httpMethod = $this->request->getHttpMethod();
        
        //valida as rotas
        foreach ($this->routes as $key => $value) {
           //verifica se a rota bate o padrão
           if(preg_match($key, $uri, $matches)){
               if(isset($value[$httpMethod])){
                    //remove a primeira posição
                    unset($matches[0]);

                    //chaves
                    $keys = $value[$httpMethod]['variables'];
                    $value[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $value[$httpMethod]['variables']['request'] = $this->request;

                    return $value[$httpMethod];
               }

               throw new Exception("Método não permitido", 405);
           }
        }

        //url não encontrada
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * metódo que retorna a uri sem prefixo
     *
     * @return  string
     */
    private function getUri(){
        //uri da request
        $uri = $this->request->getUri();

        //divide a uri com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //retorna a uri sem prefixo
        return end($xUri);
    }

    /**
     * metódo que define uma rota GET
     *
     * @param   string $route   
     * @param   array  $params
     */
    public function get($route, $params = []){
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * metódo que define uma rota POST
     *
     * @param   string $route   
     * @param   array  $params
     */
    public function post($route, $params = []){
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * metódo que define uma rota PUT
     *
     * @param   string $route   
     * @param   array  $params
     */
    public function put($route, $params = []){
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * metódo que define uma rota DELETE
     *
     * @param   string $route   
     * @param   array  $params
     */
    public function delete($route, $params = []){
        return $this->addRoute('DELETE', $route, $params);
    }
}