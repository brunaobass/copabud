<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author bruno
 */
class Model {
    
    protected $db;
    public function __construct() {
        global $db;
        
        $this->db = $db;
    }
    
    protected function where($campo,$condicao,$valores,$tabela){
        
        $resultado = array();
        $campos = implode(',',$campo);
        $cond = "";   
        $num_condicoes = count($condicao);
        
        for($i=0;$i<$num_condicoes;$i++){
            
            $cond .= $condicao[$i]." = :".$condicao[$i];
            if($i<($num_condicoes-1)){
                $cond .= " AND ";
            }
        }
        $sql = "SELECT ".$campos." FROM ".$tabela." WHERE ".$cond;
        $sql = $this->db->prepare($sql);

        for($i=0;$i<count($condicao);$i++){
            $sql->bindValue(':'.$condicao[$i],$valores[$i]);
        }
        
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $resultado = $sql->fetchAll();
        }
        
        return $resultado;   
    }
}
