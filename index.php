<?php
$urlsList = '';
$webURL = '';
if(isset($_POST['submit']) && !empty($_POST['webURL'])){
	$webURL = $_POST['webURL'];
	$webURL = filter_var($webURL, FILTER_SANITIZE_URL);
	if(!filter_var($webURL, FILTER_VALIDATE_URL) === false){		
		$urlContent = file_get_contents($webURL);
		$dom = new DOMDocument();
		@$dom->loadHTML($urlContent);
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		
		for($i = 0; $i < $hrefs->length; $i++){
			$href = $hrefs->item($i);
			$url = $href->getAttribute('href');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			// validate url
			if(!filter_var($url, FILTER_VALIDATE_URL) === false){
				$urlsList .= '<li><a href="'.$url.'" target="_blank">'.$url.'</a></li>';
			}
		}
		$urlsList = '<ul>'.$urlsList.'</ul>';
	}else{
		$urlsList = '<p>URLs not found.......</p>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>How to Extract All URLs from a Web Page using PHP by Lesson Blog Spot</title>
<style type="text/css">
input[type="text"]{width: 250px;height: 35px;font-size: 20px;}
input[type="submit"]{font-size: 20px;font-weight: bold;}
ul{ text-align:left;}
</style>
</head>
<body>
<div class="container">
<form method="post">
    <input type="text" name="webURL" value="<?php echo $webURL; ?>"/>
    <input type="submit" name="submit" value="Extract URLs"/>
</form>
<?php if(!empty($urlsList)){ 
echo '<h3>URLs From '.$webURL.'</h3>';
echo $urlsList;
} ?>
</div>
</body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81415917-1', 'auto');
  ga('send', 'pageview');

</script>
</html> 