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
    
    public function getClassificao($id_edicao){
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
    public function atualizaClassificacao($id_edicao,$id_equipe,$pontos,$tipo_resultado,$anula){
        
        
        if($anula == 1){
            $valor_tipo_resultado = "-1";
            $pontos*= -1;
        }
        else {
            $valor_tipo_resultado = "+1";
        }
        echo "<br>Valor tipo de resultado:".$valor_tipo_resultado;
        $sql = "UPDATE players_edicao SET ".$tipo_resultado." = ".$tipo_resultado.$valor_tipo_resultado.", pontos = pontos+".$pontos
                . " WHERE id_edicao = :id_edicao AND id_equipe = :id_equipe";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":id_equipe",$id_equipe);
        $sql->execute();
    }
}
