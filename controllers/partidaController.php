<?php

class partidaController extends Controller{
    public function index(){
    
        
    }
    
    public function salva_partida(){
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id_partida',FILTER_VALIDATE_INT);
            $gols_mandante = filter_input(INPUT_POST, 'gols_mandante',FILTER_VALIDATE_INT);
            $gols_visitante = filter_input(INPUT_POST, 'gols_visitante',FILTER_VALIDATE_INT);
        }
        
        $partida = new Partidas();
        //verifica se é uma partida da segunda fase, caso seja pega o id_playoff
        if($partida->getFase($id)>0){
            $this->atualizaGolsPlayoffs($partida,$id, $gols_mandante, $gols_visitante,1);
        }
        $partida->atualizaPartida($id,$gols_mandante,$gols_visitante);
        
    }
    
    public function cancela_partida(){
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
            $gols_mandante = filter_input(INPUT_POST, 'gols_mandante',FILTER_VALIDATE_INT);
            $gols_visitante = filter_input(INPUT_POST, 'gols_visitante',FILTER_VALIDATE_INT);
            
        }
        
        $partida = new Partidas();
        if($partida->getFase($id)>0){
            $this->atualizaGolsPlayoffs($partida,$id, $gols_mandante*(-1), $gols_visitante*(-1),-1);    
        }
        
        $partida->cancelaPartida($id);
    }
    public function resetar(){
       if(isset($_POST)){
           $id_edicao= filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
       }

       $partida = new Partidas();
       $partida->resetaPartidas($id_edicao);
   }
   private function atualizaGolsPlayoffs($partida,$id_partida,$gols_mandante,$gols_visitante,$jogo_finalizado_flag){
       //verifica se é uma partida da segunda fase, caso seja pega o id_playoff
        $id_playoff = $partida->getIDPlayoff($id_partida);
        $playoff = new Playoffs();
        
        //verifica se é o primeiro ou segundo jogo
        if($partida->getIdaVolta($id_partida) == 1 ){
            $gols_time1 = $gols_visitante;
            $gols_time2 = $gols_mandante;
            echo '<br>Partida de IDA';
        }
        else{
            $gols_time1 = $gols_mandante;
            $gols_time2 = $gols_visitante;
        }
        $playoff->atualizaGols($id_playoff, $gols_time1, $gols_time2);
        $playoff->atualizaJogosFinalizados($id_playoff,$jogo_finalizado_flag);
        
   }

}
