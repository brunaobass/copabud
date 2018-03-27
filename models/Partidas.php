<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Partidas
 *
 * @author bruno
 */
class Partidas extends Model {
    //put your code here
    public function inserePartida($rodada,$mandante,$visitante){
        $sql = "INSERT INTO partidas (id_edicao,rodada,mandante,visitante) VALUES (2,?,?,?)";
        
        $sql = $this->db->prepare($sql);
        $sql->execute(array($rodada,$mandante,$visitante));
    }
    
    public function getPartidas($id_edicao){
        $partidas = array();
        $sql = "SELECT * FROM partidas WHERE id_edicao = :id_edicao";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
        
        if($sql->rowCount()>0){
            $partidas = $sql->fetchAll();
        }
        
        return $partidas;
    }
    
    public function getTotalRodadas($id_edicao){
        $sql = "SELECT MAX(rodada) as num_rodadas FROM partidas WHERE id_edicao = :id_edicao";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
        
        $resultado  = array();
        if($sql->rowCount()>0){
            $resultado = $sql->fetch();
        } 
        
        return $resultado['num_rodadas'];  
    }
    
    public function getPartidasRodada($id_edicao){
        $sql = "SELECT COUNT(rodada) as num_partidas_rodadas FROM partidas WHERE id_edicao = :id_edicao AND rodada = 1";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
        $resultado  = array();
        if($sql->rowCount()>0){
            $resultado = $sql->fetch();
        } 
        
        return $resultado['num_partidas_rodadas'];
    }
}