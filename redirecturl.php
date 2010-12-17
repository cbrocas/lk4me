<?php
/*
  Copyright 2010 Christophe Brocas

  This file is part of lk4me.

  lk4me is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  lk4me is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with lk4me.  If not, see <http://www.gnu.org/licenses/>.
*/

  //get url and obtain a digest of it through sha-1 algo
  $hash = $_GET["url"];
  
  // validate url parameter (numbers or letters, 6 chars long))
  if ((preg_match("$([a-z0-9]{6})$",$hash,$values) != 1)||(strlen($hash)!=6)) {
      echo "Not a valid URL value.. Bye !";
      exit;
  }
  
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
