<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of playersController
 *
 * @author bruno
 */
class playersController extends Controller{
    public function index(){
        $dados = array(
            "titulo_pagina"=>"Players",
            "css"=>"players",
            "titulo_h1"=>"Players"
        );
        
        $players = new Players();
        $dados['players'] = $players->listaPlayers();
        $this->loadTemplate("players", $dados);
    }
    public function abrir($id){
        $dados = array(
            "titulo_pagina"=>"Players",
            "css"=>"players",
            "titulo_h1"=>"Players"
        );
        
        $players = new Players();
        $dados['players'] = $players->listaPlayers();
        if(isset($id) && filter_var($id,FILTER_VALIDATE_INT)!=false){
            $dados['player'] = $players->buscaPlayer($id);
            $dados['estatisticas_player'] = $players->getEstatiticasPlayer($id);
        }
        
        $this->loadTemplate("players", $dados);
    }

    public function cadastrar(){
        $dados = array(
            "titulo_pagina"=>"Cadastrar Player",
            "css"=>"cadastra-player",
            "titulo_h1"=>"Cadastro de Jogadores"
            );
        
        if(!empty($_POST['nome']) && !empty($_POST['username']) && !empty($_POST['email']) 
                && !empty($_POST['senha1']) && !empty($_POST['senha2'])){
            
            $valido = true;
            $nome = addslashes($_POST['nome']);
            $nome = filter_var($nome,FILTER_SANITIZE_STRING);
            
            $username = addslashes($_POST['username']);
            $username = filter_var($username,FILTER_SANITIZE_STRING);
            
            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)!=false){
                $email = addslashes($_POST['email']);
            }
            else{
                $dados['msg'] = "Entre com um email válido!";
                $valido = false;
            }
            
            if($_POST['senha1'] == $_POST['senha2']){
                $senha = $_POST['senha1'];
            }
            else{
                $dados['msg'] = "As duas senhas devem ser iguais!";
                $valido = false;
            }
            if(isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['tmp_name'])){
                $imagem = $this->salvaFoto($_FILES['arquivo']);
            }
            else{
                $imagem = "photo.png";
            }
            if($valido){
                $players = new Players(); 
                $players->insereUsuario($nome, $username, $email, $senha, $imagem);
            }    
        }
        else{
            $dados['msg'] = "Preencha todos os campos corretamente!";
        }
        $this->loadTemplate("cadastra-players", $dados);
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
