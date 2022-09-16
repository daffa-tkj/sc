<?php
error_reporting(0);
include("wp-admin/common/app_function.php");
include("wp-admin/common/config.php");
index_header($title); 
      
	  $query_under_construction=sprintf("select * from news_media where mode='active' "); 
	   if(!($result_offline_mode=mysql_query($query_under_construction))){ echo $query_under_construction.mysql_error(); exit; } 
       $row_under_construction_website_offline_mode=mysql_fetch_assoc($result_offline_mode);
	 
?>
<style>
.onoffswitch3
{
    position: relative; 
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}

.onoffswitch3-checkbox {
    display: none;
}

.onoffswitch3-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 0px solid #999999; border-radius: 0px;
}

.onoffswitch3-inner {
    display: block; width: 200%; margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
}

.onoffswitch3-inner > span {
    display: block; float: left; position: relative; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: 'Montserrat', sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}

.onoffswitch3-inner .onoffswitch3-active {
    padding-left: 10px;
   background: linear-gradient(110deg, #fdcd3b 60%, #ffed4b 60%);
	color: #000;
}

.onoffswitch3-inner .onoffswitch3-inactive {
    width: 100px;
    padding-left: 16px;
    background-color: #EEEEEE; color: #000;
    text-align: right;
}

.onoffswitch3-switch {
    display: block; width: 50%; margin: 0px; text-align: center; 
    border: 0px solid #999999;border-radius: 0px; 
    position: absolute; top: 0; bottom: 0;
}
.onoffswitch3-active .onoffswitch3-switch {
    background: linear-gradient(110deg, #ce0f49 60%, #ff4b8d 60%); left: 0;
    width: 160px;
}
.onoffswitch3-inactive{
    background: #A1A1A1; right: 0;
    width: 20px;
}
.onoffswitch3-checkbox:checked + .onoffswitch3-label .onoffswitch3-inner {
    margin-left: 0;
}


</style>
<?php if($row_under_construction_website_offline_mode[mode]=="active"){ ?>
 <div style="padding:100px 0 0px 300px"><img src="images/sorry.jpg"></div>
 <?php }else{?> 

<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- start slide -->
<link rel="stylesheet" href="air-slider/air-slider.min.css">

<?php
	               $update=sprintf("UPDATE visitor_counter SET 
						count_name=count_name+1
						",  $id);
				   if(!($result_visitor=mysql_query($update))){echo $update.mysql_error(); exit;}
				  
                 ?>
  <!-- end slide-->
                 

  <!-- END header -->
  <!-- BEGIN content -->
 


<!------ Include the above in your HEAD tag ---------->

<!------ Include the above in your HEAD tag ---------->

<div class="onoffswitch3">
    <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox" id="myonoffswitch3" checked>
    <label class="onoffswitch3-label" for="myonoffswitch3">
        <span class="onoffswitch3-inner">
            <span class="onoffswitch3-active">
			<?php
 $query=sprintf("select * from breaking_news WHERE news='news' ORDER BY b_id"); 
 if(!($result=mysql_query($query))){ echo $query.mysql_error(); exit; } 
 while($row_breaking_news=mysql_fetch_array($result)){?>	
                <marquee class="scroll-text"><?php echo $row_breaking_news["wp_b_title"]; ?></marquee>
				<?php } ?>
                <span class="onoffswitch3-switch">महत्वाच्या बातम्या<span class="glyphicon glyphicon-remove"></span></span>
            </span>
            
        </span>
    </label>
</div>




  <div id="content">
	
<?php
$que="select * from news_media WHERE  permition='Home' AND news_format='localnews' ORDER BY n_id DESC";
$pagesize=10;
$the_query  = pagination($que,$_REQUEST[page],null,$curr_query,$pagesize);	
$real_string     = explode("~" , $the_query);
$que= $que.$cstr." LIMIT ". $real_string[0];
$show_status     = $real_string[2]; 
$show_pagination = $real_string[1];
if (!($page_res = mysql_query($que))) 
{ echo "FOR QUERY: $strsql<BR>".mysql_error(); 	exit;}
$rowCount = mysql_num_rows($page_res);
$srnum=$real_string[0][0];
$srnum= $real_string[0];//--this is used to the next page no so that the srno at page comes in sequence
$srnum=explode(",",$srnum);
$count=$srnum[0];
     //$que=sprintf("select * from news_media WHERE  permition='active' ORDER BY n_id DESC "); 
	// if(!($res=mysql_query($que))){ echo $que.mysql_error(); exit; } 
      while($row_news_video=mysql_fetch_array($page_res)){?>	
<div class="post">
 <div class="thumb">
<a href="detail_news_vnxpres.php?id=<?php echo $row_news_video[n_id];?>">
<?php if($row_news_video['s_image']==""){ ?><img src="images/icon-no-image.png" class="alignright" style="border:#ccc solid 1px;width:260px;height:160px;box-shadow:0 4px 10px 0 rgba(0,0,0,0.3);" > <?php }else{?>
 <img src="<?php echo "server_upload/".$uploadpath.$row_news_video["s_image"];?>" class="alignright" style="border:#ccc solid 1px;width:260px;height:160px;box-shadow:0 4px 10px 0 rgba(0,0,0,0.3);"  />
<?php } ?>
 </a>
 <p class="date">&nbsp; बातम्या - <?php echo $row_news_video[wp_news_city];?> &nbsp; |  &nbsp; 
 बातमीची तारीख : <?php echo date('d  M  Y',strtotime($row_news_video['wp_news_date'])); ?> </p>
 </div>  
	<h2><a href="detail_news_vnxpres.php?id=<?php echo $row_news_video[n_id];?>">
	<b><small><?php echo stripslashes (substr($row_news_video["wp_news_title"],0,180));?></b>..</a></small></h2>
		<hr>
	 <p> <small><?php echo stripslashes (substr($row_news_video["wp_news_desc"],0,800));?>..</p></small>
	  
	   <p class="date alignleft btn3"><b> - VNX बातम्या </b> &nbsp;|&nbsp; <a href="detail_news_vnxpres.php?id=<?php echo $row_news_video[n_id];?>&typ=<?php echo strtolower(str_replace(' ', '+', $row_news_video['wp_news_title']) ); ?>"> अधिक वाचा.. </a></p>


	</div>
	
	 <?php } ?>

		
    <!-- end post -->
   

    <!-- begin post navigation -->
      <!-- begin post navigation -->
      <div class="postnav" >
      <ul>
        <li><div id="pageNavPosition"><?php echo $show_pagination;?></div></li>
	      </ul>
      <div class="break"></div>
    </div>
	
	


    <!-- end post navigation -->
  </div>
  
  <!-- END content -->
 
  <div id="sidebar"><br/>
  
  <?php rightpanel(); ?>
 
   <?php site_footer(); ?>
  <!-- END footer -->

<!-- END wrapper -->

</html>
<?php } ?>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.newsticker.js"></script>
<script>
// start
$(function() {
  $('.ui-newsticker').newsticker();
});
</script>
<button onclick="_pcq.push(['triggerOptIn',{httpWindowOnly: true}]);">

</button>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
	<style type="text/css">
		 ul.slide{margin:0;
				  padding:0;
				  height:170px;
				  list-style-type:none;
				  }
		 ul.slide li{float:left;padding:0px 3px;
					 list-style-type:none;}
		 ul.slide img{border:1px solid silver;
					 height:150px;}
					 
					 .btn3{
			padding:4px;
			background-color:#fff;
			color:#000;
			border-radius:20px;
			padding-left:20px;padding-right:20px;
			border:2px solid #fff;
			box-shadow:0 4px 10px 0 rgba(0,0,0,0.3);
			cursor: pointer;
			width:150px;
		}
		</style>
		 <link href="css/thumbnail-slider.css" rel="stylesheet" type="text/css" />
    <script src="js/thumbnail-slider.js" type="text/javascript"></script>
		
<style type="text/css">
.blink {
  animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite;
  color:#FFFF00;
 
  font-family:cambria;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@import url('https://fonts.googleapis.com/css?family=Montserrat');



</style>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
