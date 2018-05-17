<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Classificacao
 *
 * @author bruno
 */
class Classificacao extends Model{
    
    public function getClassificacao($id_edicao){
        
        $classificao = array();
        $sql = "SELECT pe.*,(pe.gols_pro - pe.gols_contra) AS saldo_gols,e.nome as equipe,e.imagem as imagem, "
                . "e.sigla as sigla FROM players_edicao pe INNER JOIN equipes e ON pe.id_equipe = e.id "
                . "WHERE pe.id_edicao = :id_edicao ORDER BY pontos DESC,vitorias DESC,saldo_gols DESC,gols_pro DESC,equipe";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
        if($sql->rowCount() > 0){
            $classificao = $sql->fetchAll();
        }
        
        return $classificao;
    }
    public function atualizaClassificacao($id_edicao,$id_equipe,$pontos,$tipo_resultado,$gols_pro,$gols_contra,$anula){
        
        
        if($anula == 1){
            $valor_tipo_resultado = "-1";
            $pontos*= -1;
            $gols_pro*=-1;
            $gols_contra*=-1;
            $jogos = '-1';
        }
        else {
            $valor_tipo_resultado = "+1";
            $jogos = '+1';
        }
        $sql = "UPDATE players_edicao SET ".$tipo_resultado." = ".$tipo_resultado.$valor_tipo_resultado.","
                . "jogos = jogos ".$jogos.", pontos = pontos + :pontos, gols_pro = gols_pro + :gols_pro, gols_contra "
                . "= gols_contra + :gols_contra". " WHERE id_edicao = :id_edicao AND id_equipe = :id_equipe";
        
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":pontos",$pontos);
        $sql->bindValue(":gols_pro",$gols_pro);
        $sql->bindValue(":gols_contra",$gols_contra);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":id_equipe",$id_equipe);
        $sql->execute();
    }
    
    public function resetaClassificacao($id_edicao){
        echo 'ID Edicao:'.$id_edicao;
        $sql = "UPDATE players_edicao SET pontos = 0, jogos = 0, vitorias = 0, empates = 0, derrotas = 0, "
                . "gols_pro = 0, gols_contra = 0 WHERE id_edicao = :id_edicao";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
    }
}
