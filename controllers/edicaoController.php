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
            if($this->verificaTime($nome, $sigla)){
                $json['erro'] = "Este time já foi cadastrado anteriormente!";
                echo json_encode($json);
                exit;
            }
        
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
        $json['sigla'] = $sigla;
        echo json_encode($json);
    }
    private function verificaTime($nome,$sigla){
        $equipes = new Equipes();
        
        return $equipes->verificaTime($nome, $sigla);
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
    
    public function gerar_tabela(){
        
        $dados = array();
        $rodadas = array();
        
        if(isset($_POST)){
            var_dump($_POST);
            $participantes = $_POST['participante'];
            $times = $_POST['time'];
            $edicao = filter_input(INPUT_POST, 'edicao',FILTER_SANITIZE_STRING);
            
            $copia_participantes = array_unique($participantes);
            $copia_times = array_unique($times);
            
            if((count($copia_participantes)!= count($participantes))|| (count($copia_times)!= count($times))){
                echo "Não é permitido equipes ou participantes repetidos...<br>";
            }
        }
        else{
            echo 'ERRO AO CADASTRAR PARTICIPANTES...<br>';
        }
        exit;
        global $mandantes;
        global $visitantes;
        $mandantes = array("Barcelona","Chelsea","Real Madrid","Manchester United");
        $visitantes = array("Bayern","PSG","Liverpool","Manchester City");
        
        $num_partidas = count($visitantes); 
        $num_times = $num_partidas*2;
        $temp = "bibo";
        $temp2 = "bobi";
        
        $partidas = new Partidas();
        for($rodada = 0;$rodada<($num_times-1);$rodada++){
            $rodadas[$rodada] = array(
                "rodada"=>($rodada+1),
                "mandantes"=>$mandantes,
                "visitantes"=>$visitantes
            );
            
            $this->inserirPartida($rodada+1,$mandantes,$visitantes,$partidas,$num_partidas);
            $this->reorganiza($num_partidas);
        }

        $dados["rodadas"] = $rodadas;
        $dados["num_partidas"] = $num_partidas;
        
        $this->loadTemplate("tabela",$dados);
    }
    
    private function reorganiza($num_partidas){
        global $mandantes;
        global $visitantes;
        for($i = 0;$i<$num_partidas;$i++){
                if($i == 0){
                    $temp = $mandantes[$i+1];                     
                    $mandantes[$i+1] = $visitantes[$i];   
                    $visitantes[$i] = $visitantes[$i+1];
                }
                else if($i==($num_partidas-1)){
                    $visitantes[$i] = $temp;
                }
                else{
                    $temp2 = $mandantes[$i+1];
                    $mandantes[$i+1] = $temp;
                    $visitantes[$i] = $visitantes[$i+1];
                    $temp = $temp2;
                }   
            }  
    }
    private function inserirPartida($rodada,$mandantes,$visitantes,$partidas,$num_partidas){
        
        for($i=0;$i<$num_partidas;$i++){
            $partidas->inserePartida($rodada, $mandantes[$i], $visitantes[$i]);
        }
    }
}

