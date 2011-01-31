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
  
  include('html/lk4me.html.inc.php');
  require('lib/lk4me.php');

  // filter url received through Query String
  $url = filter_var($_GET["url"],FILTER_SANITIZE_URL);

  $hash = sha1($url); 
  $baseurl = getURIbase();

  // display error message if unable to generate a short url for a long one
  if (!generateShortURI($hash, $baseurl, &$shorturl))
  { 
      echo "<span class=\"red\">ERROR: Unable to generate a free value of 6 characters for the short URL. Sorry</span> <br/>";

  }
  // if we succeed to generate the shorturl, the shorturl var set 
  // by the function will be displayed.
  require('html/form.html.inc.php');
?>
</body>
</html>
