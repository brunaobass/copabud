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
    protected function where($campo, $condicao, $valores,$tabela = null) {
        $resultado = parent::where($campo, $condicao, $valores, "partidas");
        return $resultado;
    }
    public function inserePartida($id_edicao,$rodada,$mandante,$visitante,$fase){
        $sql = "INSERT INTO partidas (id_edicao,rodada,id_mandante,id_visitante,partida_jogada,fase) VALUES (?,?,?,?,?,?)";
        
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_edicao,$rodada,$mandante,$visitante,0,$fase));
    }
    public function criaPlayoff($id_edicao,$fase,$id_playoffs){
        $sql = "INSERT INTO partidas (id_edicao,fase,id_playoffs) VALUES (?,?,?)";
        
        $sql = $this->db->prepare($sql);
        $sql->execute(array($id_edicao,$fase,$id_playoffs));
    }
    public function atualizaPartida($id,$gols_mandante,$gols_visitante){
        
        $sql = "UPDATE partidas SET gols_mandante = :gols_mandante, gols_visitante = :gols_visitante, partida_jogada = 1"
                . " WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":gols_mandante",$gols_mandante);
        $sql->bindValue(":gols_visitante",$gols_visitante);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    
    public function cancelaPartida($id){
        $sql = "UPDATE partidas SET gols_mandante = 0, gols_visitante = 0, partida_jogada = 0"
                . " WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    public function getPartidas($id_edicao,$fase){
        $partidas = $this->where(
            array("*"), 
            array("id_edicao","fase"), 
            array($id_edicao,$fase)
        );
        
        return $partidas;
    }
    public function getPartida($id){
        $partida = $this->where(
            array("*"), 
            array("id"), 
            array($id)
        );
        
        return $partida[0];
    }
    public function getUltimaPartida(){
        
        $partida = array();
        $sql = 'SELECT * FROM partidas ORDER BY id DESC LIMIT 1';
        
        $sql = $this->db->query($sql);
        
        if($sql->rowCount()>0){
            $partida = $sql->fetch();
        }
        
        return $partida;
        
    }

    public function getPlayoffs($id_edicao,$fase){
        
        $playoffs = array();
        $sql = "SELECT * FROM partidas WHERE id_edicao = :id_edicao AND fase > :fase";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":fase",$fase);
        $sql->execute();
        
        if($sql->rowCount()>0){
            $playoffs = $sql->fetchAll();
        }
   
        return $playoffs;
    }
    public function getIDPlayoff($id){
        $resultado = $this->where(
            array("id_playoffs"), 
            array("id"), 
            array($id)
        );
        
        
        
        return $resultado[0]['id_playoffs'];
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
    
    public function verificaPartidaRealizada($id_partida){
        $sql = "SELECT partida_jogada FROM partidas WHERE id = :id_partida AND partida_jogada = 1";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_partida",$id_partida);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }
        
        return false;
    }
    public function resetaPartidas($id_edicao){
        $sql = "UPDATE partidas SET gols_mandante = 0, gols_visitante = 0, partida_jogada = 0 WHERE id_edicao = :id_edicao";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->execute();
    }
    
    public function verificaFimFase($id_edicao,$fase){
        
        $sql = "SELECT partida_jogada FROM partidas WHERE id_edicao = :id_edicao AND partida_jogada = 0  AND fase"
                . " = :fase";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_edicao",$id_edicao);
        $sql->bindValue(":fase",$fase);
        $sql->execute();
        if($sql->rowCount() == 0){
            return true;
        }
        
        return false;
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
    
    public function relacionaPartidaPlayoff($id){
        //relaciona o id do playoff às partidas de cada fase
        $id_playoffs = Playoffs::inserePlayoff();
        
        
        $sql = "UPDATE partidas SET id_playoffs = :id_playoffs WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id_playoffs",$id_playoffs);
        $sql->bindValue(":id",$id);
        
        $sql->execute();
    }
    
    public function atualizaPlayoffs($id_partida,$mandante,$visitante,$ida_volta){
        $sql = "UPDATE partidas SET id_mandante = :mandante, id_visitante = :visitante, ida_volta = :ida_volta"
                . " WHERE id = :id_partida";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":mandante",$mandante);
        $sql->bindValue(":visitante",$visitante);
        $sql->bindValue(":ida_volta",$ida_volta);
        $sql->bindValue(":id_partida",$id_partida);
        
        $sql->execute();
    }
    
    public function getFase($id){
        $sql = "SELECT fase FROM partidas WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id",$id);
        
        $sql->execute();
        if($sql->rowCount() > 0){
            $resultado = $sql->fetch();
        }
        
        return $resultado['fase'];
    }
    
    public function getIdaVolta($id){
        $sql = "SELECT ida_volta FROM partidas WHERE id = :id";
        $sql = $this->db->prepare($sql);
        
        $sql->bindValue(":id",$id);
        
        $sql->execute();
        if($sql->rowCount() > 0){
            $resultado = $sql->fetch();
        }
        
        return $resultado['ida_volta'];
    }
}
