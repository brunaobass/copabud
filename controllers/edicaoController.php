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
        $this->criar();
    }
    
    public function criar(){//chama a página utilizada para inserir os dados para criação de uma nova edição do torneio
        $dados = array(
            "titulo_pagina"=>"Nova Edição",
            "titulo_h1"=>"Nova Edição",
            "css"=>"nova_edicao"
        );
        
        $this->loadTemplate('nova_edicao',$dados);
    }
    
    public function listar_players(){
        //busca os jogadores cadastrados, para deixá-los disponíveis como opção 
        //na página de criação da nova edição
        $players = new Players();
        $participantes = $players->listaPlayers();
        echo json_encode($participantes);
    }
    public function listar_times(){
        //busca os jogadores cadastrados, para deixá-los disponíveis como opção 
        //na página de criação da nova edição
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
        //verifica se o novo time inserido já está cadastrado no banco de dados
        $equipes = new Equipes();
        return $equipes->verificaTime($nome, $sigla);
    }

    private function salvaFoto($arquivo){
       //verifica se o arquivo é válido salva a imagem do time no servidor
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
    private function cria_edicao($edicao){
        $edicoes = new Edicoes();        
        return $edicoes->inserirEdicao($edicao);
    }

    private function cadastra_participantes($participantes,$times,$id_edicao){
        
        $edicoes = new Edicoes();
        
        for($i = 0;$i<count($participantes);$i++){
           echo '<br>ID Edição '.$i.':'.$id_edicao.'<br>';
           $edicoes->inserirPlayersEdicao($participantes[$i], $id_edicao, $times[$i]);
        }
        
    }
    public function gerar_tabela(){
        //gera a tabela com as equipes participantes e redireciona para a página de classificação e jogos
        $dados = array();
        $rodadas = array();
        
        if(isset($_POST)){
            
            $participantes = $_POST['participante'];
            $times = $_POST['time'];
            $edicao = filter_input(INPUT_POST, 'edicao',FILTER_SANITIZE_STRING);
            $num_classificados = filter_input(INPUT_POST, 'classificados',FILTER_VALIDATE_INT);
            
            $copia_participantes = array_unique($participantes);
            $copia_times = array_unique($times);
            
            if((count($copia_participantes)!= count($participantes))|| (count($copia_times)!= count($times))){
                $_SESSION['erro'] = "Não é permitido equipes ou participantes repetidos...";
                header("Location: ".BASE_URL."edicao/criar");
                exit;
            }
            if($num_classificados > count($participantes)){
                $_SESSION['erro'] = "O número de classificados deve ser menor ou igual ao número de participantes...";
                header("Location: ".BASE_URL."edicao/criar");
                exit;
            }
            $id_edicao = $this->cria_edicao($edicao);
            echo '<br>ID retornado:'.$id_edicao.'<br>';
            $this->cadastra_participantes($participantes, $times, $id_edicao);
        }
        else{
            echo 'ERRO AO CADASTRAR PARTICIPANTES...<br>';
        }
        
        global $mandantes;
        global $visitantes;
        $mandantes = array();
        $visitantes = array();
        
        $num_partidas = count($participantes)/2;
        for($i=0;$i<$num_partidas;$i++){
            $mandantes[$i] = $times[$i]; 
            $visitantes[$i] = $times[$i+$num_partidas];
        }

        $num_times = $num_partidas*2;
        
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
        $rodada_returno = 0;
        for($rodada = $num_times-1;$rodada<($num_times-1)*2;$rodada++){
            
            $rodadas[$rodada] = array(
                "rodada"=>($rodada+1),
                "mandantes"=> $visitantes,
                "visitantes"=>$mandantes
            );
            
            
            $rodada_returno++;
            $this->inserirPartida($rodada+1,$rodadas[$rodada]['mandantes'],$rodadas[$rodada]['visitantes'],
                    $partidas,$num_partidas);
            $this->reorganiza($num_partidas);
            
        }
        $this->gera_playoffs($id_edicao,$num_classificados);
        $dados["rodadas"] = $rodadas;
        $dados["num_partidas"] = $num_partidas;
        
        $this->loadTemplate("tabela",$dados);
    }
    private function gera_playoffs($id_edicao,$num_classificados){
        $partidas = new Partidas();
        $playoffs = new Playoffs();
        $num_confrontos = $num_classificados/2;
        echo '<br>Gerou Playoff! Número de classificados: '.$num_classificados.'<br>';
        echo 'Número de confrontos na fase: '.$num_confrontos.'<br>';
        if($num_classificados>=2){
            $num_fases_playoff = $this->getNumPlayoffs($num_classificados);
            $ids_playoffs = array();
            for($i=0;$i<$num_confrontos;$i++){
                //partidas de ida
                $ids_playoffs[$i] = $playoffs->inserePlayoff();
                $partidas->criaPlayoff($id_edicao, $num_fases_playoff,$ids_playoffs[$i]);
            }
            
            foreach ($ids_playoffs as $id_playoffs){
                $partidas->criaPlayoff($id_edicao, $num_fases_playoff,$id_playoffs);
            }
                                    

            $this->gera_playoffs($id_edicao, $num_confrontos);
        }
        
    }
    private function  getNumPlayoffs($num_equipes){
        $num_fases = 0;
        while ($num_equipes>=2){
            $num_equipes = $num_equipes/2;
            $num_fases++;
        }
        
        return $num_fases;
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
    private function inserirPartida($rodada,$mandantes,$visitantes,$partidas,$limite){
        $edicoes = new Edicoes();
        $id_edicao = $edicoes->getUltimaEdicao();
        
        for($i=0;$i<$limite;$i++){
            $partidas->inserePartida($id_edicao,$rodada, $mandantes[$i], $visitantes[$i],0);  
        }
    }
    
}

