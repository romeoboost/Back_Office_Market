<?php
    class Models{
        static $connection = array();
        public $conf = 'default';
        public $db;
        public $table = false;
        public $primarykeys = 'id';

        public function __construct() {
            if($this->table == FALSE){
               $this->table = strtolower(get_class($this)).'s'; 
            }
            $conf = conf::$database[$this->conf];
            if(isset(Models::$connection[$this->conf])){ 
                $this->db = Models::$connection[$this->conf] ;                
                return true;                
                }
            try{
                 $pdo = new PDO('mysql:dbname='.$conf['dbname'].';host='.$conf['hostname'], $conf['login'], $conf['passwd'],
                             array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                 Models::$connection[$this->conf] = $pdo;
                 $this->db = Models::$connection[$this->conf]; 
            }catch (PDOException $e) {
                if(conf::$debug >= 1){
                   echo$e->getMessage(); 
                }else{
                    die('Impossible de se connecter à la base de données');
                }                
            }
            
        }
        
        public function find($req, $table=null){
           if($table){
             $this->table = $table;  
           } 
           $sql = 'SELECT ';
           //reglage pour les doublons
           if(isset($req['distinct'])){
              $sql .= 'DISTINCT '; 
           }
           //reglage pour les champs
           if(isset($req['fields'])){
              if(is_array($req['fields'])){
                  $sql .= implode(', ',$req['fields']); 
               }else {
                  $sql .= $req['fields']; 
               }              
           }else{
              $sql .= '*'; 
           } 
           $sql .= ' FROM '.$this->table.' AS '.get_class($this).'';
            //condition
           if(isset($req['condition'])){
               $sql .= ' WHERE '; 
               if(!is_array($req['condition'])){
                  $sql .= $req['condition']; 
               }else{
                   $cond = array();
                   foreach ($req['condition'] as $k=>$v){
                       if(!is_numeric($v)){
                          $v = $this->db->quote($v); 
                       }
                       $cond[] = "$k=$v";
                   }
                   $sql .= implode(' AND ', $cond);
               }
               
           }
           //group by
           if(isset($req['group'])){
              $sql .= ' GROUP BY '.$req['group'];             
           }

           //reglage order by
           if(isset($req['order'])){
              $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param'];              
           }
           //reglage pour LIMIT
           if(isset($req['limit'])){
              $sql .= ' LIMIT '.$req['limit'];              
           }           
           //die ($sql);
           $pre = $this->db->prepare($sql);
           $pre->execute();
           if(isset($req['assos'])){
             return $pre->fetchAll(PDO::FETCH_ASSOC);  
           }else{
             return $pre->fetchAll(PDO::FETCH_OBJ);  
           }
           
//           debug($sql);
        }
          
        public function findfirst($req, $table=null){
           if(isset($table)){
             $this->table = $table;  
           }
            return current($this->find($req, $this->table));
        }

        //Select count(*), `id_categorie_produit` from produits group by `id_categorie_produit`
        
        public function findCount($condition, $table){ // $condition est pour tout ce qui vient apres le WHERE dans la req SQL
            $res = $this->findfirst(array(
               'fields' => 'COUNT('.$this->primarykeys.') as count',
               'condition' => $condition 
            ),$table);
            return $res->count;            
        }

        public function findCountAll($table){ // $condition est pour tout ce qui vient apres le WHERE dans la req SQL
            $res = $this->findfirst(array(
               'fields' => 'COUNT('.$this->primarykeys.') as count'
            ),$table);
            return $res->count;            
        }

        public function findSum($condition, $fields, $table){ // $condition est pour tout ce qui vient apres le WHERE dans la req SQL
            $res = $this->findfirst(array(
               'fields' => 'SUM('.$fields.') as count',
               'condition' => $condition 
            ),$table);
            return $res->count;            
        }

        public function findSumAll($fields, $table){ // renvoi la somme des element d'un champs
            $res = $this->findfirst(array(
               'fields' => 'SUM('.$fields.') as count'
            ),$table);
            return $res->count;            
        }
        
        public function delete($req, $table){
            $sql = 'DELETE FROM '.$table;
            if(isset($req['condition'])){
               $sql .= ' WHERE '; 
               if(!is_array($req['condition'])){
                  $sql .= $req['condition']; 
               }else{
                   $cond = array();
                   foreach ($req['condition'] as $k=>$v){
                       if(!is_numeric($v)){
                          $v = $this->db->quote($v); 
                       }
                       $cond[] = "$k=$v";
                   }
               }
               $sql .= implode(' AND ', $cond);
           }else{
               return false;
           }
           //debug($sql);
           $pre = $this->db->prepare($sql);
           $pre->execute();
        }
        
        Public function insert($req, $table){
            $sql = ' INSERT INTO '.$table.' (';
            $sql .= implode(', ', $req['fields']).')';
            $sql .= ' VALUE (:'.implode(', :',$req['fields']).')';
            //debug($sql);
            //debug($req['values']);
            $pre = $this->db->prepare($sql);
            $pre->execute($req['values']);
        }
        
       Public function update($req, $table){
           $cond = array();
           $sql = ' UPDATE '.$table.' SET ';
           $sql .= implode('=?, ', $req['fields']).'=?';
           if(isset($req['condition'])){
               $sql .= ' WHERE '; 
               if(!is_array($req['condition'])){
                  $sql .= $req['condition']; 
               }else{
                   //$cond = array();
                   foreach ($req['condition'] as $k=>$v){
                       if(!is_numeric($v)){
                          $v = $this->db->quote($v); 
                       }
                       $cond[] = "$k=$v";
                   }
                  $sql .= implode(' AND ', $cond); 
               }
               //debug($sql);
           }else{
               //return false;
           }
           //die($sql);
          //echo $sql;
           $pre = $this->db->prepare($sql);
           $pre->execute($req['values']);
          //debug($sql);
//           debug($req['values']);
        }
        
        public function findJoin($req, $maintable, $secondtable, $thirdtable=NULL){
            $sql = ' SELECT ';            
            $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
            $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
            if(isset($req['count'])){
              $sql .= ', COUNT('.$req['count']['champs'].') AS '.$req['count']['alias'];
            }
            if(isset($thirdtable)){
                $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
            }
            $sql .= ' FROM '.$maintable;
            $sql .= ' INNER JOIN '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
            if(isset($thirdtable)){
              $sql .= ' INNER JOIN '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
            }
            if(isset($req['condition'])){
                  $sql .= ' WHERE '.$req['condition']; 
            }

            //group by
            if(isset($req['group'])){
              $sql .= ' GROUP BY '.$req['group'];             
            }

            if(isset($req['order'])){
                if(is_array($req['order'])){
                   $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
                }else{
                  $sql .= ' ORDER BY '.$req['order'].' ASC';  
                }
            }
            if(isset($req['limit'])){
              $sql .= ' LIMIT '.$req['limit'];              
            } 

            //debug($req['fields'][1]);
            //die(debug($sql));
            $pre = $this->db->prepare($sql);
            $pre->execute();
            return $pre->fetchAll(PDO::FETCH_OBJ);
        }

        public function findLeftJoin($req, $maintable, $secondtable, $thirdtable=NULL){
            $sql = ' SELECT ';            
            $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
            $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
            if(isset($thirdtable)){
                $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
            }
            $sql .= ' FROM '.$maintable;
            $sql .= ' RIGHT JOIN '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
            if(isset($thirdtable)){
              $sql .= ' INNER JOIN '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
            }
            if(isset($req['condition'])){
                  $sql .= ' WHERE '.$req['condition']; 
            }
            if(isset($req['order'])){
                if(is_array($req['order'])){
                   $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
                }else{
                  $sql .= ' ORDER BY '.$req['order'].' ASC';  
                }
            }
            //debug($req['fields'][1]);
            /*debug($sql);
            die();*/
            //debug($sql);
            $pre = $this->db->prepare($sql);
            $pre->execute();
            return $pre->fetchAll(PDO::FETCH_OBJ);
        }

        public function findJoinType($req, $maintable, $secondtable, $thirdtable=NULL){
            $sql = ' SELECT ';            
            $sql .= $maintable.'.'.implode(', '.$maintable.'.',$req['fieldsmain']);
            $sql .= ', '.$secondtable.'.'.implode(', '.$secondtable.'.',$req['fieldstwo']);
            if(isset($thirdtable)){
                $sql .= ', '.$thirdtable.'.'.implode(', '.$thirdtable.'.',$req['fieldsthree']);
            }
            $sql .= ' FROM '.$maintable;
            $sql .= ' '.$req['fields'][0]['type'];
            $sql .= ' '.$secondtable.' ON '.$maintable.'.'.$req['fields'][0]['main'].' = '.$secondtable.'.'.$req['fields'][0]['second'];
            if(isset($thirdtable)){
              $sql .= ' '.$req['fields'][1]['type'];
              $sql .= ' '.$thirdtable.' ON '.$maintable.'.'.$req['fields'][1]['main'].' = '.$thirdtable.'.'.$req['fields'][1]['third']; 
            }
            if(isset($req['condition'])){
                  $sql .= ' WHERE '.$req['condition']; 
            }
            if(isset($req['order'])){
                if(is_array($req['order'])){
                   $sql .= ' ORDER BY '.$req['order']['champs'].' '.$req['order']['param']; 
                }else{
                  $sql .= ' ORDER BY '.$req['order'].' ASC';  
                }
            }
            //debug($req['fields'][1]);
            /*debug($sql);*/
            //die($sql);
            $pre = $this->db->prepare($sql);
            $pre->execute();
            return $pre->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function clear($table) {
            $sql = 'DELETE FROM ';
            $sql .= $table; 
//            echo $sql;
            $pre = $this->db->prepare($sql);
            $pre->execute();
        }
    }
    
?>