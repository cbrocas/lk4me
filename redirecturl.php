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

  require('lib/lk4me.php');

  //get url and obtain a digest of it through sha-1 algo
  $shortURL = $_GET["url"];
  
  if (!validShortURL($shortURL)) {
      include('html/lk4me.html.inc.php');
      echo "Not a valid Short URL value. Bye !";
      exit;
  }
  	
  $urlinfile = "";
  if (existingShortURL($shortURL, &$urlinfile)) {
      header("Location: ".$urlinfile);
  }
  else  { 
      include('html/lk4me.html.inc.php');
      echo $shortURL." is not an existing short URL value.";
  }
?>
