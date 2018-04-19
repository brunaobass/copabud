<?php
define('SEMIFINAL', 1);
define('DECISAO', 2);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class classificacaoController extends Controller{
    
    public function index(){
        
        $dados = array();
        
        $dados['titulo_pagina'] = 'Classificação e Jogos';
        $dados['css'] = 'classificacao';
        $dados['titulo_h1'] = 'Classificação e Jogos';
        
        $classif = new Classificacao();
        $partidas = new Partidas();
        $edicoes = new Edicoes();
        if(!isset($_POST['edicao'])){
            $id_edicao = $edicoes->getUltimaEdicao();
            echo 'Edicao:'.$id_edicao;
        }
        else{
            $id_edicao = filter_input(INPUT_POST, 'edicao',FILTER_VALIDATE_INT);
        }
        $dados['edicoes'] = $edicoes->listaEdicoes();
        $dados['classificacao'] = $classif->getClassificacao($id_edicao);
        if($partidas->verificaFimFase1($id_edicao,0)){
            $fase = 1;
            
            $this->verificaFase($id_edicao, $fase);
               
           
           
           $dados['playoffs'] = $partidas->getPlayoffs($id_edicao, $playoffs);
           var_dump($dados['playoffs']);
        }
        
        $lista_partidas = $partidas->getPartidas($id_edicao);
        
        //pegando os dados das equipes do banco de dados a partir do id_edicao
        for($i = 0; $i< count($lista_partidas);$i++){
            $equipes = new Equipes();
            $lista_partidas[$i]['mandante'] = $equipes->getEquipe($lista_partidas[$i]['id_mandante']);
            $lista_partidas[$i]['visitante'] = $equipes->getEquipe($lista_partidas[$i]['id_visitante']);   
        }
        
        $dados['partidas'] = $lista_partidas;
        $dados['num_rodadas'] = $partidas->getTotalRodadas($id_edicao);
        $dados['num_partidas_rodada'] = $partidas->getPartidasRodada($id_edicao);
        $dados['id_edicao'] = $id_edicao;
        $this->loadTemplate('classificacao',$dados);
    }
    
    public function verifica_partida(){

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }
        $partidas = new Partidas();
        echo $partidas->verificaPartidaRealizada($id);
    }

    public function atualiza_classificacao(){
        if(isset($_POST)){
            $id_edicao = filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
            $id_equipe = filter_input(INPUT_POST, 'id_equipe',FILTER_VALIDATE_INT);
            $pontos =  filter_input(INPUT_POST, 'pontos',FILTER_VALIDATE_INT);
            $tipo_resultado = filter_input(INPUT_POST, 'tipo_resultado',FILTER_SANITIZE_STRING);
            $gols_pro =  filter_input(INPUT_POST, 'gols_pro',FILTER_VALIDATE_INT);
            $gols_contra =  filter_input(INPUT_POST, 'gols_contra',FILTER_VALIDATE_INT);
            $anula = $_POST['anula']; 
        }

        $classificacao = new Classificacao();
        $classificacao->atualizaClassificacao($id_edicao,$id_equipe,$pontos,$tipo_resultado.'s',$gols_pro,$gols_contra,$anula);
        
        $classificacao_atual = $classificacao->getClassificao($id_edicao);
        
        echo json_encode($classificacao_atual);
        
    }
    
    public function resetar(){
         if(isset($_POST)){
            $id_edicao= filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
        }
        
        $classificacao = new Classificacao();
        $classificacao->resetaClassificacao($id_edicao);
    }
    
    private function getFinalistas($classificacao){
        
        $finalistas = array();
        
        if(count($classificacao)>=6){
            $num_equipes = 4;
        }
        else {
            $num_equipes = 2;
        }
        for($i=0;$i<$num_equipes;$i++){
            $finalistas[$i]['id'] = $classificacao[$i]['id_player'];
            $finalistas[$i]['equipe'] = $classificacao[$i]['equipe'];
            $finalistas[$i]['imagem'] = $classificacao[$i]['imagem'];
            $finalistas[$i]['sigla'] = $classificacao[$i]['sigla'];
        }
        
        
        return $finalistas;
    }
    
    private function geraPlayoffs($finalistas,$num_equipes,$id_edicao){
        
        $mandantes = array();
        $visitantes = array();
        $partidas = new Partidas();
        $fase;
        if($num_equipes == 4){
            $mandantes[0] = $finalistas[0];
            $mandantes[1] = $finalistas[2];
            $visitantes[0] = $finalistas[3];
            $visitantes[1] = $finalistas[1];
            $fase = 1;//fase 1 indica que as partidas são referentes à semi final
            
            $partidas->inserePartida($id_edicao, null, $mandantes[0]['id'], $visitantes[0]['id'],$fase);
            $partidas->inserePartida($id_edicao, null, $mandantes[1]['id'], $visitantes[1]['id'],$fase);
            $partidas->inserePartida($id_edicao, null, $visitantes[0]['id'], $mandantes[0]['id'],$fase);
            $partidas->inserePartida($id_edicao, null, $visitantes[1]['id'], $mandantes[1]['id'],$fase);
        }
        else{
            $mandantes[0] = $finalistas[0];
            $visitantes[0] = $finalistas[1];
            $fase = 2;//fase 1 indica que as partidas são referentes à final
           
            $partidas->inserePartida($id_edicao, null, $mandantes[0]['id'], $visitantes[0]['id'],$fase);
            $partidas->inserePartida($id_edicao, null, $visitantes[0]['id'], $mandantes[0]['id'],$fase);
            
            
        }
        $playoffs = $partidas->getPlayoffs($id_edicao, $fase);
    }
    
    private function verificaFase($id_edicao,$fase){
        $partidas = new Partidas();
        if($partidas->verificaPlayoff($id_edicao,$fase) || $fase!=3){
                if($partidas->verificaFimFase($id_edicao, $fase)){
                    $this->verificaFase($id_edicao, $fase+1);
                }
            }
            else{
              $finalistas = $this->getFinalistas($dados['classificacao']); 
              $dados['finalistas'] = $finalistas; 
              geraPlayoffs($finalistas,count($finalistas),$id_edicao);  
            }
    }
}

/*if($partidas->verificaPlayoffs($id_edicao,SEMIFINAL)){
    $finalistas = $this->getFinalistas($dados['classificacao']); 
    $dados['finalistas'] = $finalistas; 
    geraPlayoffs($finalistas,count($finalistas),$id_edicao);
 }else if($partidas->verificaPlayoffs($id_edicao, DECISAO)){
    $finalistas = $this->getFinalistas($dados['classificacao']); 
    $dados['finalistas'] = $finalistas; 
    geraPlayoffs($finalistas,count($finalistas),$id_edicao);
 }*/