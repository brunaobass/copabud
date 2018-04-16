<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estatisticasController
 *
 * @author bruno
 */
class estatisticasController extends Controller{
    public function index(){
        $dados = array(
            "titulo_pagina"=>"Estatísticas",
            "titulo_h1"=>"Estatísticas",
            "css"=>"estatisticas"
        );
        
        $this->loadTemplate("estatisticas",$dados);
    }
}
