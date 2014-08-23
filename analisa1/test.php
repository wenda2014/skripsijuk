<?php //test.php
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
require_once('questionsandanswers.php');
require_once('functions.php');
if (!isset($_POST['submitter'])) {

    if(isset($_POST['register'])) {
		$username = trim(strip_tags(stripslashes($_POST['username'])));
		$file = "leaders.xml";
 		$xml = simplexml_load_file($file);
		foreach($xml->user as $user) {
			if ($user->name == $username) {
 			$_SESSION['error'] = 'That name is already registered, please choose another.';
 			header('Location: index.php');
 			exit();
 			}
 		}
	
		$_SESSION['user'] = $username;
		$_SESSION['score'] = 0;
		$_SESSION['correct'] = array(); 
		$_SESSION['wrong'] = array();
		$_SESSION['finished'] = 'no';
		if (isset($_SESSION['error']))
		unset($_SESSION['error']); 
		$num = 0;
	} else {
		$random = rand(1,1000);
		$_SESSION['user'] = 'Anon'. $random;
		$_SESSION['score'] = 0;
		$_SESSION['correct'] = array(); 
		$_SESSION['wrong'] = array(); 
		$_SESSION['finished'] = 'no';
		$num = 0;
	}
} else {
	$num = (int) $_POST['num'];
	$postedanswers = str_replace("_"," ",$_POST['answers']);
	if ($postedanswers == $answers[$num]['0']) {
		$_SESSION['score']++;
		$_SESSION['correct'][] = $postedanswers; 
	} else {
		$_SESSION['wrong'][] = $postedanswers;
	} 
	if ($num < count($questions)-1) {
		$num++;
	} else {
		$last = true;
		$_SESSION['finished'] = 'yes';
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style1.css" type="text/css" />
<title>The Web Acronym Test</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../TableCSSCode.css" rel="stylesheet" type="text/css">

<?php 
if (!isset($last)) {
	echo "<script type=\"text/javascript\" src=\"form.js\"></script>";
}
?>
</head>
<body background="images/Lighthouse.jpg">
<div id="wrapper">
<div id="intro"><table class="CSSTableGenerator">
<tr><td>
Aplikasi Analisa Kelayakan UMR</td></tr><tr><td>
<noscript>
<?php if(isset($_SESSION['user'])) echo "<h4>Pengguna: {$_SESSION['user']}</h4>"; ?></noscript>
</div><!--intro-->
<div id="quiz">
<?php 
if (!isset($last)) {  ?>
<h2>Pertanyaan <?php echo $num+1; ?>:</h2>
<p><strong><?php echo $questions[$num]; ?></strong> </p>
<form id="questionBox" method="post" action="test.php">
<ul>
<?php 
$pattern = ' ';
$replace = '_';
$shuffledAnswers = shuffle_assoc($answers[$num]);
#var_dump($newanswers);
foreach ($shuffledAnswers as $answer) {
	$answer2 = str_replace($pattern,$replace,$answer);
	echo "<li><input type=\"radio\" id=\"$answer2\" value=\"$answer2\" name=\"answers\" />\n";
	echo "<label for=\"$answer2\">$answer</label></li>\n";
}
?>
</ul>
<p><input type="hidden" name="num" value="<?php echo $num; ?>" />
<input type="hidden" name="submitter" value="TRUE" />
<input type="submit" id="submit" name="submit" value="Pilih" /></p>
</form>
<?php } else { 
$file = "leaders.xml";
 $xml = simplexml_load_file($file);
 $user = $xml->addChild('user');
 $uname = $user->addChild('name',$_SESSION['user']);
 $uscore = $user->addChild('score',$_SESSION['score']);
 $xml->asXML("leaders.xml");
 
echo "<h2 id=\"score\"> Hasil analisa Anda :</h2>\n
 <h3>{$_SESSION['score']}/11</h3><h4>Kesimpulan :</h4>";
  if($_SESSION['score'] <= 1) echo "<p id=\"verdict\">LAYAK</p>\n
  <p>
  Penjelasan </br>
Hasil analisa  :  Upah anda  LAYAK</br>
Solusinya:
Nikmati upah layak anda.</br>

Kesimpulan diperoleh setelah anda menentukan fakta yang ada adalah :</br>
<=1 P = ya     ,p=pertanyaan                 

  </p>
  ";
 
 if(($_SESSION['score'] > 1) && ($_SESSION['score'] <= 7)) echo "<p id=\"verdict\">KURANG LAYAK</p>\n</br>
 <p>
 Penjelasan </br>
Hasil analisa  :  Upah anda KURANG LAYAK</br>
Solusinya:
Segera lapor dan konsultasi ke Serikat pekerja anda.</br>
Kesimpulan diperoleh setelah anda menentukan fakta yang ada adalah :</br>
>1 <=7 P =ya      ,p=pertanyaan                 

 </p>
 ";
 
 if(($_SESSION['score'] > 7) && ($_SESSION['score'] <= 11)) echo "<p id=\"verdict\">TIDAK LAYAK</p>
</br>
<p>Penjelasan </br>
Hasil analisa  :  Upah anda TIDAK LAYAK</br>
Solusinya:
Segera lapor dan konsultasi ke Serikat pekerja anda. </br>
Kesimpulan diperoleh setelah anda menentukan fakta yang ada adalah :</br>
> 7 <=11 P =ya      ,p=pertanyaan                 
</p> 
 \n";
 
 echo "<p id=\"compare\"><a href=\"index.php\">Mulai analisa lagi <img src=\"images/arrow.png\" /></a><a href='../index.html'>
 <input type='button' value='Home'></a>
 </p>";
}
?></td></tr></table>
</div><!--quiz-->
</div><!--wrapper-->
</body>
</html>
