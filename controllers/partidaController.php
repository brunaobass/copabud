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
        $partida->atualizaPartida($id,$gols_mandante,$gols_visitante);
    }
    
    public function cancela_partida(){
        if(isset($_POST)){
            $id = filter_input(INPUT_POST, 'id',FILTER_VALIDATE_INT);
        }
        
        $partida = new Partidas();
        $partida->cancelaPartida($id);
    }
    public function resetar(){
       if(isset($_POST)){
           $id_edicao= filter_input(INPUT_POST, 'id_edicao',FILTER_VALIDATE_INT);
       }

       $partida = new Partidas();
       $partida->resetaPartidas($id_edicao);
   }


}
