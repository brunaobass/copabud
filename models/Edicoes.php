<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Edicao
 *
 * @author bruno
 */
class Edicoes extends Model{
   
    public function inserirEdicao($edicao){
        $sql = "INSERT INTO edicao SET edicao = :edicao";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":edicao",$edicao);
        $sql->execute();
        
        $id = $this->db->lastInsertId();
        echo "Ultimo id inserido:".$id;
        return $id;
    }
    
    public function inserirPlayersEdicao($id_player,$id_edicao,$id_equipe){
        
        $sql = "INSERT INTO players_edicao (id_player, id_edicao,id_equipe) VALUES (:id_player,:id_edicao,:id_equipe)";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_player",$id_player);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":id_equipe",$id_equipe);
        
        $sql->execute();
    }
    
    public function getUltimaEdicao(){
        $sql = "SELECT MAX(id) AS id_edicao FROM edicao";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount()>0){
            $resultado = $sql->fetch();
            return $resultado['id_edicao'];
        }
    }
    
    public function listaEdicoes(){
        $array = array();
        $sql = "SELECT * FROM edicao";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount() > 0){
           $array = $sql->fetchAll(); 
        }
        
        return $array;        
    }
    
    public function getEdicao($id){
        $sql = "SELECT * FROM edicao WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id",$id);
        $sql->execute();
        
        if($sql->rowCount() > 0){
            return $sql->fetch(); 
        }
    }
}
