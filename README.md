# EXTRACT-URL-FROM-WEBSITE-IN-PHP
http://lessonblogspot.info/articles-details?articles_id=37

<?php
$urlsList = '';
$webURL = '';
if(isset($_POST['submit']) && !empty($_POST['webURL'])){
    $webURL = $_POST['webURL'];
    $webURL = filter_var($webURL, FILTER_SANITIZE_URL);
    if(!filter_var($webURL, FILTER_VALIDATE_URL) === false){        
        $urlContent = file_get_contents($webURL);
        $dom = new DOMDocument();
        @$dom--->loadHTML($urlContent);
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
 
<div class="container">
<form method="post">
    <input type="text" name="webURL" value="<?php echo $webURL; ?>">
    <input type="submit" name="submit" value="Extract URLs">
</form>
<?php if(!empty($urlsList)){ 
echo '<h3-->URLs From '.$webURL.'';
echo $urlsList;
} ?>
</div>
