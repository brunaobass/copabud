<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Playoffs
 *
 * @author bruno
 */
class Playoffs extends Model{
    protected function where($campo, $condicao, $valores,$tabela = null) {
        $resultado = parent::where($campo, $condicao, $valores, "playoffs");
        return $resultado;
    }
    public function inserePlayoff(){
        $sql = "INSERT INTO playoffs () VALUES ()";
        
        $sql = $this->db->prepare($sql);
        $sql->execute();
        
        return $this->db->lastInsertId();
    }
    public function atualizaPlayoff($id,$id_time1,$id_time2){
        $sql = "UPDATE playoffs SET id_time1 = :id_time1, id_time2 = :id_time2 WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id",$id);
        $sql->bindValue(":id_time1",$id_time1);
        $sql->bindValue(":id_time2",$id_time2);
        
        $sql->execute();
        
    }

    public function atualizaGols($id,$gols_time1,$gols_time2){
        
        $sql = "UPDATE playoffs SET total_gols_time1 = total_gols_time1 + :gols_time1, "
                . "total_gols_time2 = total_gols_time2 + :gols_time2 WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":gols_time1",$gols_time1);
        $sql->bindValue(":gols_time2",$gols_time2);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    public function atualizaJogosFinalizados($id,$jogos_finalizados){
        $sql = "UPDATE playoffs SET jogos_finalizados = jogos_finalizados + :jogos_finalizados WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":jogos_finalizados",$jogos_finalizados);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }

    public function getJogosFinalizados($id){
        $resultado = $this->where(
            array("jogos_finalizados"), 
            array("id"), 
            array($id)
        );
   
        return $resultado[0]['jogos_finalizados'];
    }

    public function getPlacarFinal($id){
        $placar = $this->where(
                array("id_time1","id_time2","total_gols_time1","total_gols_time2"), 
                array("id"), 
                array($id)
            );

        return $placar[0];
    }
    
    public function getDisputaPenaltis($id){
        $disputa = $this->where(
                array("disputa_penaltis"), 
                array("id"), 
                array($id)
            );

        return $disputa[0]["disputa_penaltis"];
    }
    
    public function atualizaPenalti($id,$gols_time1,$gols_time2){
        
        $sql = "UPDATE playoffs SET penaltis_time1 = :gols_time1, penaltis_time2 = :gols_time2, disputa_penaltis = 1"
                . " WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":gols_time1",$gols_time1);
        $sql->bindValue(":gols_time2",$gols_time2);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    
    public function cancelaPenalti($id){
        $sql = "UPDATE playoffs SET penaltis_time1 = 0, penaltis_time2 = 0, disputa_penaltis = 0"
                . " WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    
    public function getResultadoPenalti($id){
        $resultado = $this->where(
            array("id_time1","id_time2","penaltis_time1","penaltis_time2"), 
            array("id"),
            array($id)
        );
        
        return $resultado[0];
    }
    
    /*public function getVencedor($id,$campo){
        $resultado = $this->where(
            array("penaltis_time1","penaltis_time2"), 
            array("id"), 
            array($valores)
        );
        
        return $resultado;
    }*/
}
