<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edicaoController
 *
 * @author bruno
 */
class edicaoController extends Controller{
    
    public function index(){
        
    }
    
    public function criar(){
        $dados = array(
            "titulo_pagina"=>"Nova Edição",
            "titulo_h1"=>"Nova Edição",
            "css"=>"nova_edicao"
        );
        
        $this->loadTemplate('nova_edicao',$dados);
    }
    
    public function listar_players(){
        $players = new Players();
        
        $participantes = $players->listaPlayers();
        
        echo json_encode($participantes);
    }
    public function listar_times(){
        $equipes = new Equipes();
        
        $times = $equipes->listaEquipes();
        
        echo json_encode($times);
    }
    public function inserir_time(){
        
        $this->loadView('insere-time');
        
    }
}
