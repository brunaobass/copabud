<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Players
 *
 * @author bruno
 */
class Players extends model{
    
    public function insereUsuario($nome,$username,$email,$senha,$imagem){
        $sql = "INSERT INTO players (nome,username,email,senha,imagem) VALUES (:nome,:username,:email,:senha,:imagem)";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":nome",$nome);
        $sql->bindValue(":username",$username);
        $sql->bindValue(":email",$email);
        $sql->bindValue(":senha",$senha);
        $sql->bindValue(":imagem",$imagem);
        
        $sql->execute();
    }
    
    public function listaPlayers(){
        
        $players = array();
        $sql = "SELECT * FROM players";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount()>0){
            $players = $sql->fetchAll();
        }
        
        return $players;
    }
    
    public function buscaPlayer($id){
        $sql = "SELECT p.*, sum(pe.gols_pro) as total_gols,sum(pe.pontos) as total_pontos,max(pe.pontos) 
            as maior_pontuacao,group_concat(' ',pe.id_edicao) as edicoes,group_concat(' ',e.nome) as equipes
            FROM players p inner join players_edicao pe ON p.id = pe.id_player INNER JOIN equipes e ON e.id = pe.id_equipe
            WHERE p.id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$id);
        $sql->execute();
        
        if($sql->rowCount()){
            return $sql->fetch();
        }
    }
    
    public function getEstatiticasPlayer($id_player){
        $sql = "SELECT pe.*,e.nome as equipe FROM players_edicao pe INNER JOIN equipes e ON pe.id_equipe = e.id WHERE id_player = :id_player ORDER BY id_edicao";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_player",$id_player);
        //$sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
        
        if($sql->rowCount()){
            return $sql->fetchAll();
        }
    }
    
    
    public function getEstatiticasPlayerUltimaEdicao($id_player){
        $sql = "SELECT jogos,vitorias,empates,derrotas, gols_pro FROM players_edicao WHERE id_player = :id_player"
                ."AND id_edicao = :id_edicao";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_player",$id_player);
        $sql->bindValue(":id_edicao", $this->getUltimaEdicao());
        $sql->execute();
        
        if($sql->rowCount()){
            return $sql->fetchAll();
        }
    }
    
    private function getUltimaEdicao(){
        $sql = "SELECT MAX(id_edicao) as ultima_edicao FROM players_edicao";
        $sql = $this->db->query($sql);
        
        $resultado = $sql->fetch();
        return $resultado['ultima_edicao'];
    }
}
