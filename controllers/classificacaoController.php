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
        $dados['titulo_h1'] = 'Classificaçãoe Jogos';
        
        $classif = new Classificacao();
        $partidas = new Partidas();
        if(!isset($_POST['id_edicao'])){
            $edicoes = new Edicoes();
            $id_edicao = $edicoes->getUltimaEdicao();
        }
        else{
            $id_edicao = filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
        }
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
        $this->loadTemplate('classificacao',$dados);
    }
    
    public function verifica_partida($id){
        $partidas = new Partidas();
        return $partidas->verificaPartidaRealizada($id);
    }
}
