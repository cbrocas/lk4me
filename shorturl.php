<?php
  //get url and obtain a digest of it through sha-1 algo
  $url = filter_var($_GET["url"],FILTER_VALIDATE_URL);
  
  //$url  = $_GET["url"];
  $hash = sha1($url);

  echo "Your URL [".$url."]<br/>";
  
  //while () {
  // extract from the digest the firt 2 chars and the first 6 characters
  $shift = 0;

  $character1 = substr($hash, $shift , 1);
  $character2 = substr($hash, $shift+1, 1);
  $hash6characters = substr($hash, $shift, 6);

  $filepath = $character1."/".$character2."/".$hash6characters;
  
  $shorturl = "http://".$_SERVER['HTTP_HOST']."/";
  
  $tmp = explode("/",$_SERVER['SCRIPT_NAME']);

  $count = count($tmp) - 1;

  for ($i=1;$i<$count;$i++) {   
     $shorturl = $shorturl . $tmp[$i] ."/";
  }

  $shorturl = $shorturl . $hash6characters;

  if (is_file($filepath)) {
      $f = fopen($filepath,"r");
      $urlinfile = fgets($f,16000);
      fclose($f); 

      if ($urlinfile == $url) {
          echo "- SHORT URL (already known): [".$shorturl."]<br/>";
      }
      else {
	      echo "collision !";
	      exit(1);
      }
      
  }
  else {
      echo "- SHORT URL (new): [" .$shorturl."]<br/>";
      $f = fopen($filepath,"w+");
      fputs($f, $url);
      fclose($f);
  }

?>
