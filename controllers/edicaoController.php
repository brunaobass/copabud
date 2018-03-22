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
        $json = array();
        if(isset($_POST)){
            $nome = filter_input(INPUT_POST, 'nome',FILTER_SANITIZE_STRING);
            $sigla = filter_input(INPUT_POST, 'sigla',FILTER_SANITIZE_STRING);
        }
        
        if(isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['tmp_name'])){
            $imagem = $this->salvaFoto($_FILES['arquivo']);        
        }
        
        else{
            $imagem = "logo.png";
        }
        
        $equipes = new Equipes();
        $id = $equipes->cadastraEquipe($nome, $sigla, $imagem);
        $json['nome'] = $nome;
        $json['id'] = $id;
        echo json_encode($json);
    }
    private function salvaFoto($arquivo){
       
        switch ($arquivo['type']){
            case "image/jpeg" :
                $extensao = ".jpg";
                break;
            case "image/jpg" :
                $extensao = ".jpg";
                break;
            case "image/png" :
                $extensao = ".png";
                break;
            default :
                $dados['msg'] = "Formato de imagem inválido!";
                header(BASE_URL."players/cadastrar");
                exit();
        }
        
        $nome_arquivo = md5(time().rand(0, 999)).$extensao;
        move_uploaded_file($arquivo['tmp_name'], "assets/images/".$nome_arquivo);
        
        return $nome_arquivo;
    }
}
