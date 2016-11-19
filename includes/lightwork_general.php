<?php
/*
    (c) copyright 2011 nadlabs.co.uk. All rights reserved.
    
    
    
    http://www.nadlabs.co.uk/licence.php

*/
require_once(APP_INC_PATH."class.phpmailer.php");
class general{
    
    
    public static function getScreenRes(){
        if (isset($_SESSION['nl_screenres'])){
            return $_SESSION['nl_screenres'];
        }
        else{
            return 'not set';
        }
     
    }
    
   
    
    public static function get_search_term_engine($url){
        $query_term ='';
        //add more engines as required
       // $url = 'http://www.yahoo.co.uk/?hl=en&cp=33&gs_id=29&xhr=t&q=detect+search+engine+referrer+php&pf=p&sclient=psy&source=hp&pbx=1&oq=detect+search+engine+referrer+php&aq=f&aqi=&aql=&gs_sm=&gs_upl=&bav=on.2,or.r_gc.r_pw.&fp=42c36fc8de204fb4&biw=1024&bih=604';
        if(preg_match('/[\.\/](google|yahoo|bing|mywebsearch|ask|alltheweb)\.[a-z\.]{2,5}[\/]/i',$url,$search_engine)){
        
                    //new google uses a # in some cases so PHP_URL_QUERY will not work.
                    preg_replace('/#/', '?', $url, 1);
                    //$search_engine[0]= str_replace('/', '', $search_engine[0]);
                    $search_engine[0]= preg_replace('/\//', '', $search_engine[0], 1);
                   $search_engine[0]= preg_replace('/./', '', $search_engine[0], 1);
                    // Parse the URL into an array
                    $parsed = parse_url( $url, PHP_URL_QUERY );
                    
                    // Parse the query string into an array
                    parse_str( $parsed, $query );
                    
                    if (isset($parsed['q'])){
                        $query_term=$parsed['q'];
                    }
                    else if (isset($parsed['p'])){
                        $query_term=$parsed['p'];
                    }
                    if(trim($query_term)!=''){
                        $query_term='---';
                    }
                    
                    return array('searchterm'=>$query_term,"searchengine"=>$search_engine[0]);
        
                    
                 
                    
             
                    
        
        
        
        }
        else{
             return array('searchterm'=>'---',"searchengine"=>'none');
        }

    }
    
    public static function getCountry(){
        
        global $conn;
        
        $country_SQL  = "SELECT 2letter FROM stats_country_ip ".
         "WHERE ipstart<=inet_aton('".dbase::globalMagic($_SERVER['REMOTE_ADDR'])."') ".
          "AND ipend>=inet_aton('".dbase::globalMagic($_SERVER['REMOTE_ADDR'])."') ";

        $dataPostBack = dbase::globalQuery($country_SQL,$conn,2);
        
        if ($dataPostBack[1] > 0){
            $resultsLoc = $dataPostBack[0];
            $countryLoc = $resultsLoc['2letter'];
          /*
            if ($countryLoc=='US'){
              //US format mm/dd/yyyy
              $_SESSION['datepref'] =2;
              
            }
            else{
              $_SESSION['datepref'] =1;
            }
            */
            return $countryLoc;
        }
        else{
            //unknown country
            return 'ZZ';
            //echo 'Hehe';
            //$_SESSION['datepref'] =1;
        }
    }
    
    public static function getBrowser(){
        
        
        $iphone     = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'iphone');
        $android    = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'android');
        $palmpre    = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'webos');
        $ipod       = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'ipod');
        $ipad       = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'ipad');
        
        $firefox    = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'firefox');
        $ie         = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'msie');
        $safari     = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'safari');
        $webkit     = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'webkit');
        $oprea      = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'opera');
        $chrome     = strpos(strtolower(" ".$_SERVER['HTTP_USER_AGENT']),'chrome');
        
        //echo $oprea;
        
        
             if ($firefox){
                  return 'FFX';
             }
             if ($ie){
                
                  $version = substr($_SERVER['HTTP_USER_AGENT'],$ie+4,1);
                  $versionArray = array ('6','7','8','9');
               
                  if (in_array($version,$versionArray)){
                    
                        return 'IE'.$version;
                    
                  }
                  else{
                    
                        return 'IEO';
                    
                  }
                
                  
             }
             
             if ($webkit){
                if ($safari && !$chrome){
                    return 'SAF';
                }
                else if ($chrome){
                    return 'GOO';
                }
                else{
                    return 'WBK';
                }
             }
            
             if ($oprea){
                  return 'OPA';
             }
             
             //these are OS not Browsers?
             
             
             if ($iphone){
                  return 'IPHO';
             }
             if ($android){
                  return 'ANDR';
             }
             if ($palmpre){
                  return 'PALM';
             }
             if ($ipod){
                  return 'IPOD';
             }
             if ($ipad){
                  return 'IPAD';
             }
             
             
             
             return 'OBW';
        
    }
    
    public static function getOS(){
            $OSList = array
    
          (
    
                  // Match user agent string with operating systems
    
                  'WIN3' => 'Win16',
    
                  'WIN95' => '(Windows 95)|(Win95)|(Windows_95)',
    
                  'WIN98' => '(Windows 98)|(Win98)',
    
                  'WIN2K' => '(Windows NT 5.0)|(Windows 2000)',
    
                  'WINXP' => '(Windows NT 5.1)|(Windows XP)',
    
                  'WINS23' => '(Windows NT 5.2)',
    
                  'WINV' => '(Windows NT 6.0)',
    
                  'WIN7' => '(Windows NT 6.1)',
    
                  'WINNT' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
    
                  'WINME' => 'Windows ME',
    
                  'OBSD' => 'OpenBSD',
    
                  'SUNOS' => 'SunOS',
    
                  'LIN' => '(Linux)|(X11)',
    
                  'MACOS' => '(Mac_PowerPC)|(Macintosh)',
    
                  'QNX' => 'QNX',
    
                  'BEOS' => 'BeOS',
    
                  'OS/2' => 'OS\/2',
    
                  'SSB'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves\/Teoma)|(ia_archiver)'
    
          );    

       

        // Loop through the array of user agents and matching operating systems
        foreach($OSList as $CurrOS=>$Match)
        {
                // Find a match
                if (preg_match("/".$Match."/i", $_SERVER['HTTP_USER_AGENT']))
  
                {
                    
                        // We found the correct match
                        return $CurrOS;
                        break;
    
                }
  
        }
        return 'OOS';

      
    }
    
    public static function getLang(){
        
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            
            //only get the primary language
            
            
            if (strlen($_SERVER['HTTP_ACCEPT_LANGUAGE'])>=2){
                
                return  substr(dbase::globalMagic($_SERVER['HTTP_ACCEPT_LANGUAGE']),0,2);
                
            }
            else{
                return 'ool';
            }
            
        }
        else{
            //other, other! language - ie unknown - why ool? lol, not sure.
            return 'ool';
        }
        
        
        
    }
    
    public static function setReferInfo(){
        
        //need url, domain, referid - if present
        
        
        
        if (isset($_GET['ref'])){
            
            $_SESSION['refid']=dbase::globalMagic($_GET['ref']);
            
        }
        else{
            
            $_SESSION['refid']='';
            
        }
        
        if (isset($_SERVER['HTTP_REFERER'])){
            
            $_SESSION['refurl']     =   dbase::globalMagic($_SERVER['HTTP_REFERER']);
            
            $_SESSION['refdomain']  =   general::getDomain($_SESSION['refurl']);
            
        }
        else{
            //type in or not found
            $_SESSION['refurl']='type-in-traffic';
            $_SESSION['refdomain']='type-in-traffic';
            
        }
        
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI']) ){
            $_SESSION['landingpage']=(!empty($_SERVER['HTTPS'])) ? 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        else{
            $_SESSION['landingpage']='none--';

        }
        
        
        
        
        $_SESSION['refdataset'] = 'true';
    }
    
    public static function getDomain($url){
        
        if(filter_var($url,FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED)){
            $parseUrl = parse_url(trim($url));
            if (isset($parseUrl['host'])){
                 return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2)));
            }
            else{
                 return 'not-found';
            }
        }
        else{
            
            return 'not-found';
        }
        
    }
    
    public static function queryLike($query,$field){
        
        //do this or use match tec
        
        if (trim($query)==''){
            
            return '';
        
        }
        else{
            
            $keywords = explode(" ",trim($query));
            $searchBlock = '';
            foreach ($keywords as $value){
                
                $searchBlock .= " OR $field LIKE '%$value%'";
                
            }
            
            $searchBlock = preg_replace('/OR/','',$searchBlock,1);
            
           
            
            return $searchBlock;
            
        }
        
        
        
    }
    
    public static function nullnot($value){
        if(is_null($value) || $value==""){
            $value="0";
            return $value;
        }
        else{
            return $value;
            
        }
    }
    
    public static function globalEmail($to, $from, $content, $subject){

        //old mailer system
        //$headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
       // $headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/' . phpversion();
   
       // mail($to, $subject, $content, $headers);
       
       
       //new PHPMailer version
       /*
            THIS IS A WORK IN PROGRESS/Beta feature - default/supported setting is basic mail()
       */
       
        $mail = new PHPMailer(true);
        switch(EMAIL_METHOD){
            case 'SMTP':
                $mail->IsSMTP();
                break;
            case 'POP':
                $pop = new POP3();
                $pop->Authorise(EMAIL_HOST, 110, 30, POP_USERNAME, POP_PASSWORD, 1);
                $mail->IsSMTP();
                break;
            case 'MAIL':
                //defaults to mail()
                break;
            case 'SENDMAIL':
                //defaults to mail()
                $mail->IsSendmail();
                break;
        }
        
       
        $mail->Host       = EMAIL_HOST; 
        $mail->SMTPDebug  = false;                     // enables SMTP debug information (for testing)
        $mail->AddReplyTo($from, $from);
        $mail->AddAddress($to, $to);
        $mail->SetFrom($from, $from);
        $mail->Subject = $subject;
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer.'; 
        $mail->MsgHTML($content);
        if($mail->Send())
            return true;
        else
            return false;
            
            
         
       
        
        
    }
    
    public static function doubleSalt($toHash,$salt){
        $password = str_split(trim($toHash),(strlen(trim($toHash))/2)+1);
        $hash = sha1(hash(HASH_SETTING, $password[0].$salt.UNIQUE_SALT.$password[1]));
        return $hash;
   }
    
    
    
    
    public static function generate_salt()
    {
         // Declare $salt
         $salt = '';
    
         // And create it with random chars
         for ($i = 0; $i < 5; $i++)
         {
              $salt .= chr(rand(35, 126));
         }
         
         if (strlen(trim($salt))<3){
            $salt.'Xt)';
         }
         
         return $salt;
    }
  
    public static function _wordwrap($text,$valuelimit,$seperator)   {
        $split = explode(" ", $text);
        foreach($split as $key=>$value)   {
            if (strlen($value) > $valuelimit)    {
                $split[$key] = chunk_split($value, $valuelimit, $seperator);
            }
        }
        return implode(" ", $split);
    }
    
    public static function globalIsSet($arrayPostGet,$postGetList){
    
        $flagValidation = true;
        foreach ($postGetList as $testValue){
             
             
             if (!(isset($arrayPostGet[$testValue]))){
                
                 
                //echo 'fail---'.$testValue.'';
                  $flagValidation = false;
                  
             }
             
            
             
             
        }
       
        return $flagValidation;
     
     
     
    }
    
  public static function getHostSansWWW($Address) { 
        $parseUrl = parse_url(trim($Address)); 
        return str_ireplace('www.', '', (trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))))); 
     } 
    
    public static function is_online()
    {
        return (checkdnsrr('google.com', 'ANY') && checkdnsrr('yahoo.com', 'ANY') && checkdnsrr('microsoft.com', 'ANY'));
    }
    public static function getFile ($location){
        
        $filecontent = file_get_contents($location);

        if (!$filecontent){
            $filecontent=-1;
        }
        
        return $filecontent;
    }
    
    public static function get_url_data($url){
    
            $ch = curl_init();
    
    
            // set url
            curl_setopt($ch, CURLOPT_URL, $url);
    
            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            
            $output = curl_exec($ch);

            curl_close($ch);
            return $output;
        
    }
    
    public static function get_current_url (){
        $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } 
        else 
        {
            $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;


    }
    
    public static function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
                }
        }
        $args[] = &$data;
        array_multisort($args);
        //call_user_func_array('array_multisort', $args); // does not work in latest version of PHP5.3 onwards.
        return array_pop($args);
    }
    
    /**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
    public static function get_gravatar( $email, $s = IMG_SIZE, $d = DEFAULT_IMG_LOCATION, $r = IMG_RATING, $img = false, $atts = array() ) {
            $url = 'http://www.gravatar.com/avatar/';
            $url .= md5( strtolower( trim( $email ) ) );
            $url .= "?s=$s&d=$d&r=$r";
            if ( $img ) {

                    foreach ( $atts as $key => $val )
                            $url .= ' ' . $key . '="' . $val . '"';

            }
            return $url;
    }
    
    //http://www.mdj.us/
    public static function time_ago($date,$granularity=2) {
        $date = strtotime($date);
        $difference = time() - $date;
        $periods = array('decade' => 315360000,
            'year' => 31536000,
            'month' => 2628000,
            'week' => 604800, 
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1);
        $retval='';                     
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').$time.' ';
                $retval .= (($time > 1) ? $key.'s' : $key);
                $granularity--;
            }
            if ($granularity == '0') { break; }
        }
        return ''.$retval.' ago';      
    }

    public static function block_site_access(){
        
        global $conn;
        
        $sql_where='';
        $ipad       = dbase::globalMagic($_SERVER['REMOTE_ADDR']);
        //really only the email domain area needs to be in this else statement
      /*
        types:  ip=1
                refdomain=5
                referurl=4
                
      
      */
        
        if(isset($_SESSION['refurl'])){
            $sql_where = " OR ( blockvalue = '".$_SESSION['refurl']."' AND type=4 ) ";
        }
        
        if(isset($_SESSION['refdomain'])){
             $sql_where = " OR ( blockvalue = '".$_SESSION['refdomain']."' AND type=5 ) ";
        }
        
        
       
        $sqlBlock = " SELECT blockid FROM security_blocks WHERE (( blockvalue='$ipad' AND type=1 )  $sql_where ) AND valid=1 AND blockarea IN (2,3) ";
                    
        $dataPostBack =  dbase::globalQueryPlus($sqlBlock,$conn,2);
          
    
        if ($dataPostBack[1]>0){
         //site access blocked for this user
            return true;
            
        }
        else{
           //site access open for this user
            return false;
        }
        
    }

    
    public static function globalGetOnePieceOfData($item,$table,$where){
          global $conn;
          $where = (!$where)?'':" WHERE $where ";
          $sql = "SELECT $item FROM $table $where LIMIT 1";
    
          $dataPostBack =  dbase::globalQuery($sql,$conn,2);


        if ($dataPostBack[1]==1){
    
               return $dataPostBack[0][$item];
        }
        else{
          
          return false;
        }
    }
    
}
?>