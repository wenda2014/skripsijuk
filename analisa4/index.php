<?php //index.php
/*********Copyright (c) 2009 Ben Hall*********

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
**********************************************************/
session_name("Acronym_Test");
session_start();
$_SESSION['score'] = 0;
$_SESSION['correct'] = array(); 
$_SESSION['wrong'] = array();
$_SESSION['finished'] = 'no'; 
$_SESSION['num'] = 0;
require_once ('functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style1.css" type="text/css" />
<title>The Web Acronym Test</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../TableCSSCode.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="start.js"></script>
</head>
<body id="splash" background="images/Lighthouse.jpg">
<div id="wrapper">
<div id="intro"><table class="CSSTableGenerator">
<tr><td>Aplikasi Analisa Kelayakan UMR</td></tr><tr><td>

<div id="leaderboard">
<h2>Klik Tombol :</h2>
</div><!-- leaderboard-->
</div><!--intro-->
<div id="quiz">

<p></p>
<form id="jttt" method="post" action="test.php">
<p><input type="submit" value="Mulai Analisa" />
</p>
</form>
<form id="questionBox" method="post" action="test.php">
 
</p>
</form> </td></tr></table>
<p id="helper"><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>
</div><!--quiz-->
</div><!--wrapper-->
</body>
</html>
