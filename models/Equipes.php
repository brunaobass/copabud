<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Equipes
 *
 * @author bruno
 */
class Equipes extends Model {
    
    public function listaEquipes(){
        $equipes = array();
        $sql = "SELECT * FROM equipes";
        
        $sql = $this->db->query($sql);
        
        if($sql->rowCount()>0){
            $equipes = $sql->fetchAll();
        }
        
        return $equipes;
    }
    
}
