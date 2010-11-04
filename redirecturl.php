<?php
  //get url and obtain a digest of it through sha-1 algo
  $hash = $_GET["url"];

  // extract from the digest the firt 2 chars and the first 6 characters

  $character1 = substr($hash, 0, 1);
  $character2 = substr($hash, 1, 1);

  $filepath = $character1."/".$character2."/".$hash;

  if (is_file($filepath)) {
      $f = fopen($filepath,"r");
      $urlinfile = fgets($f,16000);
      fclose($f); 
      header("Location: ".$urlinfile);
  }
  else {
      var_dump(is_file($filepath)) . "\n";    
      echo " error -- no URL has this hash [" .$hash."]<br/>";
  }

?>
