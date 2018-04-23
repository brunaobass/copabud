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
    public function getPlayoffs($id_edicao,$fase){
        $partidas = array();
        $sql = "SELECT * FROM partidas WHERE id_edicao = :id_edicao AND fase = :fase";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":fase",$fase);
        $sql->execute();
        
        if($sql->rowCount()>0){
            $partidas = $sql->fetchAll();
        }
        var_dump($partidas);
        echo '<br>ENTROU NO MÉTODO<BR>';
        exit;
        return $partidas;
    }
    
    public function verificaPlayoff($id_edicao,$fase){
        //verifica se o playoff foi cadastrado, buscando no banco de dados, o valor da fase e comparando com o valor fornecido 
        $sql = "SELECT partida_jogada FROM partidas WHERE id_edicao = :id_edicao AND fase = :fase";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":fase",$fase);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }
        
        return false;
    } 
    
    public function inserePlayoff($id_edicao,$mandante,$visitante,$fase){
        $sql = "INSERT INTO partidas (id_edicao,rodada,id_mandante,id_visitante,partida_jogada,fase) VALUES (?,?,?,?,?,?)";
        
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_edicao,$rodada,$mandante,$visitante,0,$fase));
    }
}
