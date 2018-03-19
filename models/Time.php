<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Time
 *
 * @author bruno
 */
class Time {
    
    private $nome;
    private $sigla;
    private $imagem;
    
    public function __construct($nome,$sigla,$imagem) {
        $this->nome = $nome;
        $this->sigla = $sigla;
        $this->imagem = $imagem;
    }
    
    public function getNome(){
        return $this->nome;
    }
    public function getSigla(){
        return $this->sigla;
    }
    public function getImagem(){
        return $this->imagem;
    }
}
