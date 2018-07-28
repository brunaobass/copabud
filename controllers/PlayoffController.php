<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PlayoffController extends Controller{
    public function salva_penalti(){
        $vencedor = array();
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id_playoff',FILTER_VALIDATE_INT);
            $gols_time1 = filter_input(INPUT_POST, 'gols_time1',FILTER_VALIDATE_INT);
            $gols_time2 = filter_input(INPUT_POST, 'gols_time2',FILTER_VALIDATE_INT);
        }
        
        $playoff = new Playoffs();
        //verifica se é uma partida da segunda fase, caso seja pega o id_playoff
        echo "<br>Gols time 1: ".$gols_time1;
        echo "<br>Gols time 2: ".$gols_time2;
        $playoff->atualizaPenalti($id,$gols_time1,$gols_time2);
        $confronto = $playoff->getResultadoPenalti($id);
        $equipes = new Equipes();
        
        if($gols_time1 > $gols_time2){
            $vencedor = $equipes->getEquipe($confronto['id_time1']);
        }else if($gols_time1 < $gols_time2){
            $vencedor = $equipes->getEquipe($confronto['id_time2']);
        }
        
        echo json_encode($vencedor);
    }
    
    public function anula_penalti(){
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id_playoff'
                    . '',FILTER_VALIDATE_INT);
        }
        
        $playoff = new Playoffs();       
        $playoff->cancelaPenalti($id);
    }
    
    public function resultado_penalti(){
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id_playoff',FILTER_VALIDATE_INT);
        }
        
        $playoff = new Playoffs();       
        
        $resultado = $playoff->getResultadoPenalti($id);
        echo json_encode($resultado);
    }
}
