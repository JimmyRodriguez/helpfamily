<?php

session_start();


//session_unset();

unset($_SESSION['username']);
unset($_SESSION['userid']);
unset($_SESSION['usergroup']);
unset($_SESSION['stale']);
unset($_SESSION['token']);
unset($_SESSION['tempsalt']);

//session_destroy();
if (isset($_GET['r'])){
    
    if ($_GET['r']==0){
        header("Location: index.php?r=0");
    }
    else{
        header("Location: index.php");
    }
}
else{
    header("Location: index.php");
}

exit;


?>