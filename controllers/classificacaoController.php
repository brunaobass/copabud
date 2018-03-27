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
        
        $dados['classificacao'] = $classif->getClassificao();
        $dados['partidas'] = $partidas->getPartidas(2);
        $dados['num_rodadas'] = $partidas->getTotalRodadas(2);
        $dados['num_partidas_rodada'] = $partidas->getPartidasRodada(1);
        
        $this->loadTemplate('classificacao',$dados);
    }
}
