<?php
define('SEMIFINAL', 2);
define('DECISAO', 1);
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
        $equipes = new Equipes();
        if(!isset($_POST['edicao'])){
            $id_edicao = $edicoes->getUltimaEdicao();
            
        }
        else{
            $id_edicao = filter_input(INPUT_POST, 'edicao',FILTER_VALIDATE_INT);
        }
        $dados['edicoes'] = $edicoes->listaEdicoes();
        $dados['classificacao'] = $classif->getClassificacao($id_edicao);
        $dados['semifinal'] = $partidas->getPartidas($id_edicao, SEMIFINAL);
        
        $dados['final'] = $partidas->getPartidas($id_edicao, DECISAO);
        $fase = 0;
        
        /*if($partidas->verificaFimFase($id_edicao,0)){
            $classificados = $this->getClassificados($id_edicao);
            
            $num_fases_playoff = (count($classificados)/2);
            $fase = $this->getFase($classificados, 4);
            
            $fase_atual = $this->verificaFase($id_edicao, $fase,$num_fases_playoff);
            echo '<br>Fase atual: '.$fase_atual.'<br>';
            $playoffs = new Partidas();
            
            
            for($i = 0; $i< count($lista_playoffs);$i++){ 
                $lista_playoffs[$i]['mandante'] = $equipes->getEquipe($lista_playoffs[$i]['id_mandante']);
                $lista_playoffs[$i]['visitante'] = $equipes->getEquipe($lista_playoffs[$i]['id_visitante']);   
            }
            
            
        }*/
        
        $lista_partidas = $partidas->getPartidas($id_edicao,0);
        
        //pegando os dados das equipes do banco de dados a partir do id_edicao
        for($i = 0; $i< count($lista_partidas);$i++){ 
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
        
        $classificacao_atual = $classificacao->getClassificacao($id_edicao);
        
        echo json_encode($classificacao_atual);
        
    }
    
    public function atualiza_playoffs(){
        $json = array();
        $partida = new Partidas();
        if(isset($_POST['id_edicao'])){
            $id_edicao = filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
            
        }
        if($partida->verificaFimFase($id_edicao, 0)){
            
            $classificados = $this->getClassificados($id_edicao);
            $edicoes = new Edicoes();
            $total_classificados = $edicoes->getNumClassificados($id_edicao);
            
            $fase = $this->getFase($total_classificados);
            
            if($partida->verificaPlayoff($id_edicao, $fase)){
                $this->geraPlayoffs($classificados, count($classificados), $id_edicao, $fase);
                $partidas = $partida->getPartidas($id_edicao, $fase);
                
                $equipes = new Equipes();
                $mandantes = array();
                $visitantes = array();
                $ids_partida = array();
                
                for($i = 0; $i < count($partidas); $i++ ){
                    $ids_partida[$i] = $partidas[$i]['id']; 
                    $mandantes[$i] = $equipes->getEquipe($partidas[$i]['id_mandante']);
                    $visitantes[$i] = $equipes->getEquipe($partidas[$i]['id_visitante']);
                }
                
                $json = array(
                    "id_partida"=>$ids_partida,
                    "mandante"=>$mandantes,
                    "visitante"=>$visitantes
                );
            }
        }
        echo json_encode($json);
    }
    public function resetar(){
         if(isset($_POST)){
            $id_edicao= filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
        }
        
        $classificacao = new Classificacao();
        $classificacao->resetaClassificacao($id_edicao);
    }
    
    private function getClassificados($id_edicao){
        $classif = new Classificacao();
        $classificacao = $classif->getClassificacao($id_edicao);
        $classificados = array();
       
        if(count($classificacao)>=6){
            $num_equipes = 4;
        }
        else {
            $num_equipes = 2;
        }
        for($i=0;$i<$num_equipes;$i++){
            $classificados[$i]['id'] = $classificacao[$i]['id_equipe'];
            $classificados[$i]['equipe'] = $classificacao[$i]['equipe'];
            $classificados[$i]['imagem'] = $classificacao[$i]['imagem'];
            $classificados[$i]['sigla'] = $classificacao[$i]['sigla'];
        }
       
        return $classificados;
    }
    private function getClassificadosPlayoffs($partidas){
        //pega os vencedores com base nos gols das partidas agregadas, ou gols da disputa de pênaltis, caso ocorra
        $classificados = array();
        
        foreach ($partidas as $partida){
            if($partida['disputa_penaltis'] == 1){//se ocorreu disputa de pênaltis
                if($partida['penaltis_mandante'] == $partida['penaltis_visitante']){
                    $_SESSION['erro'] = "Não existe empates em disputas de pênaltis";
                    header("Location: ".BASE_URL."classificacao/index");
                    exit;
                }
                else if($partida['penaltis_mandante'] > $partida['penaltis_visitante']){
                    array_push($classificados, $partida['id_mandante']);
                }
                else{ 
                    array_push($classificados, $partida['id_visitante']);
                }    
            }
        }
        return $classificados;
    }

    private function geraPlayoffs($classificados,$num_equipes,$id_edicao,$fase){
        
        $mandantes = array();
        $visitantes = array();
        $partidas = new Partidas();
        $playoffs = new Playoffs();
        $num_classificados = count($classificados);
        $pos_ultimo = $num_classificados-1;
        $limite = ($num_classificados/2);
        $ida_volta = array();//armazena valores para verificar se é o jogo de ida ou jogo de volta
        for($i = 0; $i < $limite; $i++){
            
            //partida de ida(o time melhor classificado joga a partida de volta em casa)
            $mandantes[$i] = $classificados[$pos_ultimo];
            $visitantes[$i] = $classificados[$i]; 
            $ida_volta[$i] = 1;
            //partida de volta
            $mandantes[$i+$limite] = $classificados[$i];
            $visitantes[$i+$limite] = $classificados[$pos_ultimo];
            $ida_volta[$i+$limite] = 2;
            
            $pos_ultimo--;
        }  
  
        $playoffs_inseridos = $partidas->getPartidas($id_edicao, $fase);
        $jogos_ida = array();
        $jogos_volta = array();
        foreach ($playoffs_inseridos as $jogo){
            if($jogo['ida_volta'] == 1){
                array_push($jogos_ida, $jogo);
            }
            else{
               array_push($jogos_volta, $jogo); 
            }
        }
        $ids_playoffs = array();
        
        $ids_partida = array();
        $num_partidas = count($playoffs_inseridos);
        $num_confrontos = $num_partidas/2;
        
 
        if( $num_partidas>0){
            for($i = 0; $i<$num_partidas;$i++){

                $partidas->atualizaPlayoffs($playoffs_inseridos[$i]['id'], $mandantes[$i]['id'], $visitantes[$i]['id'],$ida_volta[$i]);
                if($i<$num_confrontos){    
                    array_push($ids_playoffs, $playoffs_inseridos[$i]['id_playoffs']);
                }        
            }
            
            for($i = 0;$i<$num_confrontos;$i++){
                
                $playoffs->atualizaPlayoff($ids_playoffs[$i],$visitantes[$i]['id'],
                            $mandantes[$i]['id']);
            }   
        }           
    }
    public function getFase($num_equipes){
        $fase = 0;
        
        while ($num_equipes >= 2){
            $num_equipes = ($num_equipes/2);
            $fase++;
        }

        return $fase;
    }
    private function verificaFase($id_edicao,$fase,$num_fases_playoff){
        $partidas = new Partidas();
        $playoffs = array();
        echo 'Fase atual: '.$fase.'<br>';
        if($fase >= DECISAO){
            echo 'Fase atual: '.$fase.'<br>';
           if($partidas->verificaPlayoff($id_edicao,$fase)){
                //verifica se a fase já foi liberada
                echo 'Playoff'.$fase.' liberado!<br>';

                if($partidas->verificaFimFase($id_edicao, $fase)){
                    //verifica se a fase já terminou
                    echo 'Fase'.$fase.' encerrada!<br>';
                    $this->verificaFase($id_edicao, $fase-1,$num_fases_playoff);
                }
                else{
                    echo 'Fase '.$fase.' em andamento!<br>';
                }
            }
            else{
                echo 'Playoff fase '.$fase.' ainda não criado!<br>';
                
                if($fase == $num_fases_playoff){
                   $classificados = $this->getClassificados($id_edicao);
                   echo 'Classificados da primeira fase...<br>';   
                }
                else {
                    $classificados = $this->getClassificadosPlayoffs($partidas);
                    echo 'Classificados do mata-mata...<br>';
                }
                
                $this->geraPlayoffs($classificados,count($classificados),$id_edicao,$fase);  
            } 
        }
        
        return $fase;
    }
    
    public function disputa_penaltis(){
        if(isset($_POST)){
            $id_partida = filter_input(INPUT_POST, 'id_partida',FILTER_VALIDATE_INT);
        }
        $json = array("id_partida"=>$id_partida);
        
        $partida = new Partidas();
        $jogo = $partida->getPartida($id_partida);
        $id_playoff = $jogo['id_playoffs'];
        $json["id_playoff"] = $id_playoff;
        
        $playoff = new Playoffs();
        $partidas_jogadas = $playoff->getJogosFinalizados($id_playoff);
        if($partidas_jogadas == 2){
            if($this->verificaEmpate($id_playoff,$playoff)){
                //o valor 1 indica que houve empate entra as somas dos gols
                $json["empate"] = 1;    
            }
            else{
                $json["empate"] = 0;
            }
        }
        
        echo json_encode($json);
    }
    
    private function verificaEmpate($id_playoff,$playoff){

        $placar_final = $playoff->getPlacarFinal($id_playoff);
        
        
        if($placar_final['total_gols_time1'] == $placar_final['total_gols_time2']){
            return true;
        }
        
        return false;
    }
    
    private function verificaPenaltis($id_playoff,$playoff){
        //verifica se a disputa de pênaltis já ocorreu e retorna o vencedor, caso tenha ocorrido
        //caso contrário
        $resultado = $playoff->where(
                array("total_gols_time1","total_gols_time2"),
                array("id"),
                array($id_playoff)
            );
        echo '<br> Entrou no método verifica penaltis...<br>';
        var_dump($resultado);
        exit;
    }
}
