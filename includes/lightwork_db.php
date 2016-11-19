<?php
class dbase{
    
        public static function globalMagic($stripValue){
         
            if(get_magic_quotes_gpc()) {
                
                $stripValue = stripslashes(trim($stripValue));
                                   
            }
            $stripValue = mysql_real_escape_string(trim($stripValue));
            
         
            return $stripValue  ;
        }
    
   
      
      
      
      public static function dataFormat($arrayData, $arrayType, $last){
           
           if ($arrayData==="NULL"){
                 $valueX="'".$arrayData."',";
           }
           else{
                if (strpos($arrayType,"varchar") !== false)
                {
                     
                       $valueX="'".$arrayData."',";
                     
                }
                else{
                     
                     if (strpos($arrayType,"int") !== false)
                    {
                         
                          $valueX="".$arrayData.",";
                         
                    }
                    else{
                     //date
                      if (strpos($arrayType,"date") !== false){
                          if ($arrayData==="now()"){
                               
                               $valueX="".$arrayData.","; 
                          }
                          else{
                               
                              $valueX="'".$arrayData."',"; 
         
                          }
                          
                          
                      }else{
                          if (strpos($arrayType,"timestamp") !== false){
                               if ($arrayData==="now()"){
                                    
                                    $valueX="".$arrayData.","; 
                               }
                               else{
                                    
                                   $valueX="'".$arrayData."',"; 
              
                               }
                               
                               
                           }else{
                               //other
                              $valueX="'".$arrayData."',"; 
                               
                           }
                          
                      }
                     
                     
                    }
                 
                     
                     
                     
                }
           }
     
         
           
           switch ($last) {
          case 0:
              $valueX =  $valueX;
              break;
          case 1:
              $valueX =  str_replace(",",")",$valueX);
              break;
          case 2:
              $valueX =  str_replace(",","",$valueX);
              break;
           }    
           
           
           return $valueX;
      
           
      
      }
      
      public static function globalQuery($finalSQL,$conn,$type){
           
           //need to do error checking/catching here.
           //insert
           if ($type==1){
                $results = @mysql_query($finalSQL,$conn);//or die(mysql_error());
                $uid = @mysql_insert_id();
                $mar=0;
                $mar = @mysql_affected_rows($conn);
                $dataPostBack = array($uid,$mar,@mysql_insert_id());
                
           }
           else{
                //select
                if ($type==2){
                    
                     $results = @mysql_query($finalSQL,$conn); //or die(mysql_error());
                    //echo $finalSQL."<br/>";
                     $dbarray = @mysql_fetch_array($results); //or die(mysql_error());
                     $numRow=0;
                     $numRow = @mysql_num_rows($results); //or die(mysql_error());
                     $dataPostBack = array($dbarray,$numRow);
                
                }
                else{
                       //update/delete
                       if ($type==3){
                         // echo $finalSQL;
                          $results = @mysql_query($finalSQL,$conn);
                          $mar=0;
                          $mar = @mysql_affected_rows($conn);
                         // echo $mar;
                          $dataPostBack = array("0",$mar);  
      
                     }
                     
                }
                
           }
           
           
           
           
           
           return $dataPostBack;
           
           
      }
      
   
      public static function globalQueryPlus($finalSQL,$conn,$type){
           
           //need to do error checking/catching here.
           //insert
           if ($type==1){
                $results = @mysql_query($finalSQL,$conn);
                $uid = @mysql_insert_id();
                $mar=0;
                $mar = @mysql_affected_rows($conn);
                $dataPostBack = array($uid,$mar);
                
           }
           else{
                //select
                if ($type==2){
                     //echo $finalSQL."<br/><br/>";
                     $results = @mysql_query($finalSQL,$conn);
                     //$dbarray = @mysql_fetch_rowsarr($results);
                     $numRow=0;
                     //var_dump($results);
                     $numRow = @mysql_num_rows($results);
                     $dataPostBack = array($results,$numRow);
                
                }
                else{
                       //update/delete
                       if ($type==3){
                         // echo $finalSQL;
                          $results = @mysql_query($finalSQL,$conn);
                          $mar=0;
                          $mar = @mysql_affected_rows($conn);
                         // echo $mar;
                          $dataPostBack = array("0",$mar);  
      
                     }
                     
                }
                
           }
           
           
           
           
           
           return $dataPostBack;
           
           
      }
    
      public static function loop_to_array($recordset){
        
        $set = array();
            
        while($row = mysql_fetch_array($recordset,MYSQL_ASSOC)) {
            $set[] = $row;
        }
        
        return $set;
      }
      
         public static function basic_queries($table,$id_key,$keys_values,$type,$plus){
        
        switch(strtolower($type)){
                case 'insert':
                        $type = 1;
                        $keys_sql = "";
                        $values_sql = "";
                        foreach ($keys_values as $key => $value) {
                                $keys_sql .= " `$key` , ";
                                if(trim($value)=='now()' || trim($value)=='NULL'){
                                     $values_sql .= " $value , ";   
                                }
                                else{
                                     $values_sql .= " '$value' , ";   
                                }
                                
                        }
                        
                        $keys_sql       = substr(trim($keys_sql),0,strlen(trim($keys_sql))-1);
                        $values_sql     = substr(trim($values_sql),0,strlen(trim($values_sql))-1);
                        
                        $sql = " INSERT INTO $table ($keys_sql) VALUES ($values_sql);";
                     //echo $sql;
                        break;
                case 'delete':
                        $type = 3;
                        $where_sql = "";
                        foreach ($id_key as $key => $value) {
                                
                                if(trim($value)=='now()' || trim($value)=='NULL'){
                                     $where_sql .= " $key = $value AND ";   
                                }
                                else{
                                     $where_sql .= " $key = '$value' AND ";   
                                }
                                
                        }
                        $where_sql     = substr(trim($where_sql),0,strlen(trim($where_sql))-3);
                        $sql = "DELETE $table WHERE $delete_sql";
                        
                        
                        break;
                case 'update':
                        $type = 3;
                        $update_sql = "";
                        $where_sql = "";
                        foreach ($keys_values as $key => $value) {
                                
                                if(trim($value)=='now()' || trim($value)=='NULL'){
                                     $update_sql .= " $key = $value, ";   
                                }
                                else{
                                     $update_sql .= " $key = '$value', ";   
                                }
                                
                        }
                        
                        foreach ($id_key as $key => $value) {
                                
                                if(trim($value)=='now()' || trim($value)=='NULL'){
                                     $where_sql .= " $key = $value AND ";   
                                }
                                else{
                                     $where_sql .= " $key = '$value' AND ";   
                                }
                                
                        }
                        
                        $update_sql       = substr(trim($update_sql),0,strlen(trim($update_sql))-1);
                        $where_sql     = substr(trim($where_sql),0,strlen(trim($where_sql))-3);
                        
                        $sql = " UPDATE $table SET $update_sql WHERE $where_sql ";
                        
                        
                        break;
                case 'select':
                        $type = 2;
                        $select_sql = "";
                        $where_sql = "";
                        foreach ($keys_values as $key => $value) {
                                
                                
                                     $select_sql .= " $key, ";   
                             
                                
                        }
                        
                        if($id_key!=false){
                                $where_sql = " WHERE ";
                                foreach ($id_key as $key => $value) {
                                        
                                        if(trim($value)=='now()' || trim($value)=='NULL'){
                                             $where_sql .= " $key = $value AND ";   
                                        }
                                        else{
                                             $where_sql .= " $key = '$value' AND ";   
                                        }
                                        
                                }
                        }
                        
                        
                        $select_sql    = substr(trim($select_sql),0,strlen(trim($select_sql))-1);
                        $where_sql     = substr(trim($where_sql),0,strlen(trim($where_sql))-3);
                        
                        $sql = " SELECT $select_sql FROM $table  $where_sql ";
                        break;
                
        }
       // echo $sql;
        global $conn;
        if($plus){
               return dbase::globalQueryPlus($sql,$conn,$type);
        }
        else{
               return dbase::globalQuery($sql,$conn,$type);
        }
        
      }
   
   
        /* BASIC QUERY FUNCTIONS*/
    
    public static function add_db_item($key_values,$table,$success,$fail){
        
         $dataPostBack = dbase::basic_queries($table,false,$key_values,'INSERT',false);
        
        if ($dataPostBack[1]==1){
            return array("Ack"=>"success", "Msg"=>$success);
        }
        else{
            return array("Ack"=>"fail", "Msg"=>$fail);
        }
        
    }
    
    public static function edit_db_item($id_key,$key_values,$table,$success,$fail){
        
         $dataPostBack = dbase::basic_queries($table,$id_key,$key_values,'UPDATE',false);
        
        if ($dataPostBack[1]!=-1){
            return array("Ack"=>"success", "Msg"=>$success);
        }
        else{
            return array("Ack"=>"fail", "Msg"=>$fail);
        }
        
    }
    
    public static function delete_db_item($id_key,$key_values,$table,$success,$fail){
        
         $dataPostBack = dbase::basic_queries($table,$id_key,$key_values,'DELETE',false);
        
        if ($dataPostBack[1]==1){
            return array("Ack"=>"success", "Msg"=>$success);
        }
        else{
            return array("Ack"=>"fail", "Msg"=>$fail);
        }
        
    }
    
    public static function select_db_item($id_key,$key_values,$table,$success,$fail,$loop){
        
         $dataPostBack = dbase::basic_queries($table,$id_key,$key_values,'SELECT',$loop);
        
        if ($dataPostBack[1]>0){
            if ($loop)
                return array("Ack"=>"success", "Msg"=>$success,"data"=>dbase::loop_to_array($dataPostBack[0]));
            else 
                return array("Ack"=>"success", "Msg"=>$success,"data"=>$dataPostBack[0]);
        }
        else{
            return array("Ack"=>"fail", "Msg"=>$fail);
        }
        
    }
     
     
      public static function clean_array($arr){
        
                foreach ($arr as $key => $value){
                      $arr[$key] =  dbase::globalMagic($arr[$key]);
                }
                
                return $arr;
        
      }
    


}
?>