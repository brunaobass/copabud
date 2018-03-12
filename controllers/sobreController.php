<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sobreController
 *
 * @author bruno
 */
class sobreController extends Controller{
    //put your code here
    public function index(){
        $dados = array(
            "titulo_pagina"=>"Sobre",
            "css"=>"sobre",
            "titulo_h1"=>"Sobre"
        );
       
        $this->loadTemplate("sobre", $dados);
    }
}
