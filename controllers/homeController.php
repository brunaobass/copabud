<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homeController
 *
 * @author bruno
 */
class homeController extends Controller {
    public function index(){
        $dados = array();
        
        $players = new Players();
        
        $dados['titulo_pagina'] = "Home";
        $dados['css'] = "home";
        $dados['players'] = $players->listaPlayers();
        
        $this->loadTemplate("home", $dados);
    }
}
