<?php

namespace App\Utils;

class UploadImage {

    /**
     * nome do arquivo sem extensão
     *
     * @var string
     */
    private $name;

    /**
     * extensão do arquivo sem o ponto
     *
     * @var string
     */
    private $extension;

    /**
     * quantidade de arquivos duplicados
     *
     * @var integer
     */
    private $duplicates = 0;

    /**
     * nome temporário do arquivo
     *
     * @var string
     */
    private $tmpName;

    /**
     * código de erro do upload
     *
     * @var integer
     */
    private $error;

    /**
     * construtor da classe
     *
     * @param   array  $file
     *
     */
    public function __construct($file){
        $info               = pathinfo($file['name']);

        $this->tmpName      = $file['tmp_name'] ?? '';
        $this->error        = $file['error'] ?? '';
        $this->name         = $info['filename'] ?? '';
        $this->extension    = $info['extension'] ?? '';
    }


    /**
     * método que retorna o código de erro
     *
     * @return  integer
     */
    public function getError(){
        return $this->error;
    }

    /**
     * metódo que retorna o nome do arquivo com a extensão
     *
     * @return  string
     */
    public function getBasename(){
        //verifica se tem extensão
        $extension = strlen($this->extension) ? '.'.$this->extension : '';

        //valida duplicação
        $duplicates = $this->duplicates > 0 ? '-'.$this->duplicates : '';

        return $this->name.$duplicates.$extension;
    }

    /**
     *  metódo que verifica o nome possível do arquivo
     *
     * @param   string  $dir
     * @param   boolean  $overwrite
     *
     * @return  string
     */
    private function getPossibleBasename($dir, $overwrite){
        //sobrescreve o arquivo
        if($overwrite) return $this->getBasename();

        //não sobrescreve o arquivo
        $basename = $this->getBasename();

        if(!file_exists($dir.'/'.$basename)){
            return $basename;
        }

        //incrementa duplicação
        $this->duplicates++;

        //retorna o próprio método
        return $this->getPossibleBasename($dir, $overwrite);
    }

    /**
     * metódo responsável por mover a imagem de upload
     *
     * @param   string  $dir
     * @param   boolean  $overwrite
     *
     * @return  boolean 
     */
    public function upload($dir, $overwrite = false){
        //verificar erro
        if($this->error != 0) return false;

        //resolve os links simbólicos
        $resolvedPath = realpath($dir);

        //path completo do arquivo
        $path = $resolvedPath.'/'.$this->getPossibleBasename($dir, $overwrite);


        //retorna sucesso e move o arquivo
        return move_uploaded_file($this->tmpName, $path);
    }
}