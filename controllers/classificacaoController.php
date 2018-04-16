<?php

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
        }
        else{
            $id_edicao = filter_input(INPUT_POST, 'edicao',FILTER_VALIDATE_INT);
        }
        $dados['edicoes'] = $edicoes->listaEdicoes();
        $dados['classificacao'] = $classif->getClassificao($id_edicao);
        
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
}

