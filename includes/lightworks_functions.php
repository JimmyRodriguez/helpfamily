<?php

/*
#################

    check and remove this file - do not use these functions

#################
*/


function _wordwrap($text,$valuelimit,$seperator)   {
    $split = explode(" ", $text);
    foreach($split as $key=>$value)   {
        if (strlen($value) > $valuelimit)    {
            $split[$key] = chunk_split($value, $valuelimit, $seperator);
        }
    }
    return implode(" ", $split);
}






function generate_salt()
{
     // Declare $salt
     $salt = '';

     // And create it with random chars
     for ($i = 0; $i < 3; $i++)
     {
          $salt .= chr(rand(35, 126));
     }
          return $salt;
}

function validate_username($v_username) {
   return eregi('[^[:space:]a-zA-Z0-9_@.-]', $v_username) ? FALSE : TRUE;
}



function globalMagic($stripValue){
     
       if(get_magic_quotes_gpc()) {
                                $stripValue        = stripslashes(trim($stripValue));
                               
        }
        $stripValue = mysql_real_escape_string(trim($stripValue));
        
     
     return $stripValue  ;
}

function globalEmail($to, $from, $content, $subject){
     
     
     
     $headers = 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/' . phpversion();

     mail($to, $subject, $content, $headers);
     
     
}


function nullnot($value){
    if(is_null($value) || $value==""){
        $value="0";
        return $value;
    }
    else{
        return $value;
        
    }
}

function globalIsSet($arrayPostGet,$postGetList){
     
     $flagValidation = 1;
     foreach ($postGetList as $testValue){
          
          
          if ((isset($arrayPostGet[$testValue]))){
          }
          else{
              
               $flagValidation = 0;
               
          }
          
          
          /*if ((isset($testValue)) && (trim($testValue)!="")){
               
               
               
               
          }
          else{
               
               //not set
               $flagValidation = 0;
               
          }*/
          
          
     }
     return $flagValidation;
     
     
     
}





function globalTableSimple($tableSelect,$action,$arrayData,$arrayData2,$fields,$fields2,$conn){
         
     //fields array must be real column names
     //data must be preformatted - ie with '' around strings/dates etc
    $rowCount=0;
     if ($action == 1){
          
          //insert statement required.
          
          
          $masterQ1S = "INSERT INTO ".$tableSelect." (";
          $valueInsert ="";
          $masterQ2S = "VALUES (";
          $valueActual ="";
          
          foreach($fields as $valueX1){
                 //build up two arrays - data type and column name
                 //use $fields data passed though to miss out columns if required.
                
               $valueInsert = $valueInsert."".$valueX1.",";
               
               $valueActual = $valueActual."".$arrayData[$rowCount].",";
              
               $rowCount++;
          }
         
               
               
          //need to remove trailing comma and add bracket.
          $valueInsert = substr($valueInsert,0,-1).")";
          $valueActual = substr($valueActual,0,-1).")";
          
          $completeSQL = $masterQ1S." ".$valueInsert." ".$masterQ2S." ".$valueActual;
          
     }
     else{
          
          if($action==2){
               //update statement required.
            
               
              
               
          }
          
          
          
     }
     
     
     return $completeSQL;
     
}


function globalTableMagic($tableSelect,$action,$arrayData,$arrayData2,$fields,$fields2,$conn){
     //extra data request may cause extra burden on SQL server?
     //dicountined development due to extra processing concerns.
     //use globalTableSimple for now.
     
     //fields list is column numbers starting at 0=1st column
     //data can come without '' around strings/dates etc
     
     $rowCount=0;
     $rowCount2=0;
      $rowCount3=0;
     $tableQ = "SHOW COLUMNS  FROM ".$tableSelect.";";
      //echo $q;
     $result = mysql_query($tableQ,$conn) or die("oops! theres been a slight problem. try it again.");
     //$num_rows = mysql_num_rows($result);
    
     if ($action == 1){
          
          //insert statement required.
          //fields array not required.
          
          $masterQ1S = "INSERT INTO ".$tableSelect." (";
          $valueInsert ="";
          $masterQ2S = "VALUES (";
          $valueActual ="";
          
          while($row = mysql_fetch_array( $result )) {
                 //build up two arrays - data type and column name
                 //$arrayName[$rowCount] = $row[0];
                
               $valueInsert = $valueInsert."".$row[0].",";
               //$arrayType[$rowCount] = $row[1];
              
               $valueActual = $valueActual.dataFormat($arrayData[$rowCount], $row[1],0);
              
               $rowCount++;
               
          }
         
               
               
          //need to remove trailing comma and add bracket.
          $valueInsert = substr($valueInsert,0,-1).")";
          $valueActual = substr($valueActual,0,-1).")";
          
          $completeSQL = $masterQ1S." ".$valueInsert." ".$masterQ2S." ".$valueActual;
          
     }
     else{
          
          if($action==2){
               //update statement required.
            
               
                         $masterQ1S = "UPDATE ".$tableSelect." ";
                         $masterQ1S = $masterQ1S." SET";
                         
                         $setList = "";
                         $whereList = " WHERE ";
                         
                         while($row = mysql_fetch_array( $result )) {
                              //build up two arrays - data type and column name
                            
                            
                              foreach ($fields as $checkValue){
                                   
                                   if ($checkValue==$rowCount){
                                        
                                      $setList = $setList." ".$row[0]." = ".dataFormat($arrayData[$rowCount2], $row[1],2).",";
                                      $rowCount2++;
                                   }
                              }
                             // $rowCount2=0;
                              
                               foreach ($fields2 as $checkValue1){
                                   
                                   if ($checkValue1==$rowCount){
                                        
                                      $whereList = $whereList." ".$row[0]." = ".dataFormat($arrayData2[$rowCount3], $row[1],2)." AND";  
                                      $rowCount3++;
                                   }
                              }
                            
                              
               
                              
                              $rowCount++;
                         }
                         
                         $setList = substr($setList,0,-1)."";
                         $whereList = substr($whereList,0,-3)."";
                         
                         $completeSQL = $masterQ1S." ".$setList." ".$whereList;
               
          }
          else{
               
                   if($action==3){
                   //Select statement required.
                         $masterQ1S = "SELECT # FROM ".$tableSelect." ";
                         $masterQ1S = $masterQ1S." WHERE";
                         
                         $selectList = "";
                         $whereList = "";
                         
                         while($row = mysql_fetch_array( $result )) {
                              //build up two arrays - data type and column name
                            
                            
                             if ($fields2[0]!== "*"){
                              foreach ($fields2 as $checkValue){
                                   
                                   if ($checkValue==$rowCount){
                                        
                                      $selectList = $selectList." ".$row[0].",";  
                                   }
                              }
                             }
                             else{
                              $masterQ1S=str_replace("#","*",$masterQ1S);
                              
                             }
                             
                              if ($fields[0]!== "*"){
                                   foreach ($fields as $checkValue1){
                                       
                                       if ($checkValue1==$rowCount){
                                            
                                          $whereList = $whereList." ".$row[0]." = ".dataFormat($arrayData[$rowCount2], $row[1],2)." AND";  
                                          $rowCount2++;
                                       }
                                  }
                              }
                              else{
                                   
                                   $masterQ1S=str_replace("WHERE","",$masterQ1S);
                              }
               
                              
                              $rowCount++;
                         }
                         
                         $selectList = substr($selectList,0,-1)."";
                         $whereList = substr($whereList,0,-3)."";
                         
                         $completeSQL = str_replace("#",$selectList,$masterQ1S)." ".$whereList;
                        
                   }
                   else{
                        
                        //delete statement - not really going to be used.
                        
                        
                        
                   }
               
               
               
          }
          
          
          
     }
     
     
     return $completeSQL;
     
}



function dataFormat($arrayData, $arrayType, $last){
     
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
              //what is the format for date? with quotes?
               
               
               
          }
     }
     //echo "<br>".$valueX."<br>";
   
     
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

function globalQuery($finalSQL,$conn,$type){
     
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
//need to merge GQP and GQ into one function - replace select of GQ with GQP (or gel some how)
//otherwise will keep GQ for legacy code. Silly mistake to make!
function globalQueryPlus($finalSQL,$conn,$type){
     
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

function mysql_fetch_rowsarr($result, $numass=MYSQL_BOTH) {
  $i=0;
  $keys=array_keys(mysql_fetch_array($result, $numass));
  mysql_data_seek($result, 0);
    while ($row = mysql_fetch_array($result, $numass)) {
      foreach ($keys as $speckey) {
        $got[$i][$speckey]=$row[$speckey];
      }
    $i++;
    }
  return $got;
}







function doubleSalt($toHash,$salt){
     $password = str_split(trim($toHash),(strlen(trim($toHash))/2)+1);
     $hash = md5(hash('md5', $password[0].$salt.UNIQUE_SALT.$password[1]));
     return $hash;
}

function checklogindetails($userid,$password,$conn,$checkType,$username){
     //check data here
     //echo $username;
            $arrayValues = array(globalMagic($userid));
            $arraySelect = array(0);
            $arrayPostBack = array(0,1,2,3,4,5,6,7,8,9,10,11,12);
            $sqlPostBack = globalTableMagic("user_table",3,$arrayValues,"",$arraySelect,$arrayPostBack,$conn);
            $dataPostBack = globalQuery($sqlPostBack,$conn,2);
          //  echo $sqlPostBack;
            if ($dataPostBack[1]==1){
                 //all if okay
                 
                 $dataArray = $dataPostBack[0];
                 
                 if ($dataArray["act_flag"]==1){
                    //if active
                    
                     $salt = $dataArray["p_s"];
           
                     //$encrypted = md5(md5(globalMagic($_POST["p"])).$salt);
                      $encrypted = doubleSalt(globalMagic($password),$salt);
                     // echo $encrypted."--";
                     // echo $encrypted."---".$dataArray['p_h']."\n";
                      if ($encrypted == $dataArray['p_h']){
                         return true;
                      }
                      else{
                         //fail to find
                        // echo 'hash failed';
                         return false;
                      }
                 }
                 else{
                    
                    //we are checking for purpose of changing email address - to allow for multi-change
                    //1st change will de-activate so wont work more than once - this allows it to do so.
                    if ($checkType == 2){
                         $salt = $dataArray["p_s"];
            
                         //$encrypted = md5(md5(globalMagic($_POST["p"])).$salt);
                          $encrypted = doubleSalt(globalMagic($password),$salt);
                         // echo $encrypted."---".$dataArray['p_h']."\n";
                          if ($encrypted == $dataArray['p_h']){
                             return true;
                          }
                          else{
                             // echo 'hash failed2';
                             //fail to find
                             return false;
                          }
                    }
                    else{
                         //if not for email changing then not activated check enforced.
                       return false;  
                    }
                    
                    
                    
                 }
            }
            else{
              // echo '333';
               //username does not exist   
               return false;
            }
     
     
}



function pagation($page,$way,$dataPostBack_pagenation,$overallLimit,$tag){
     
     if ($dataPostBack_pagenation[1]>0){
                $results_pagenation = $dataPostBack_pagenation[0];
               
                $totalRows = $results_pagenation['num'];
               
            }
            else{
                $totalRows=$overallLimit;
            }
            $numberOfPages = ceil($totalRows/$overallLimit);
            
            switch ($way){
                
                case 'F':
                    $page=1;
                    break;
                case 'B':
                    $page=$page-1;
                    break;
                case 'N':
                    $page=$page+1;
                    break;
                case 'L':
                    $page=$numberOfPages;
                    break;
                default:
                    $page=1;
                break;
                
                
            }
            if ($page<=0){
                $page=1;
            }
            else{
                if ($page>$numberOfPages){
                    $page = $numberOfPages;
                }
               
            }
            

            
            $start = ($page-1) * $overallLimit;
            if ($totalRows == 1){
               $repText = "reply";
            }
            else{
               $repText = "replies";
            }
            
        if ($totalRows<=10){
          return  " LIMIT $start , $overallLimit"."#"." page $page of $numberOfPages ($totalRows $repText)<input type='hidden' value='$page' id='pagenumber_$tag'/>#1";
        }
        else{
                    return  " LIMIT $start , $overallLimit"."#"." page $page of $numberOfPages ($totalRows $repText)<input type='hidden' value='$page' id='pagenumber_$tag'/>#2";

        }
        
        
     
}

?>