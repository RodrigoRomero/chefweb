<title><?php echo $title_page ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Rodrigo Romero" />
<?php
$metas = array(
	array('name' => 'description', 'content' =>$description),
	array('name' => 'keywords', 'content' => $keywords),
);

echo meta($metas);

?>

 <link rel="canonical" href="<?php echo $this->canonical_url; ?>" />

<!-- <meta property="og:locale"			   content="es_ES" />
<meta property="og:url"                content="<?php echo base_url()?>" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="<?php echo $this->evento->nombre ?>" />
<meta property="og:site_name"          content="<?php echo $this->evento->nombre?>" />
<meta property="og:description"        content="<?php echo $this->evento->bajada?>" />
<meta property="og:image"              content="<?php echo image_asset_url('av2020_og.jpg', '','') ?>" />
<meta property="og:image:width"        content="1200" />
<meta property="og:image:height"       content="627" /> -->


<script>
_base_url = "<?php echo config_item('base_url')?>"

	var config = {
		shop_url : "<?php echo config_item('base_url')?>",
		page_handle: "<?php echo (get_session('comesfrom',false))  ? get_session('comesfrom',false) : uri_string() ?>",
		customer : {
			first_name: "<?php echo (get_session('nombre', false)) ?  get_session('nombre', false) : '' ?>",
			last_name: "<?php echo (get_session('apellido', false)) ? get_session('apellido', false) : '' ?>",
			empresa: "<?php echo (get_session('empresa', false)) ?  get_session('empresa', false) : '' ?>",
			id: "<?php echo (get_session('id', false)) ?  get_session('id', false) : '' ?>",
			is_logged_in: <?php echo ($this->auth->loggedin()) ? 1 : 0 ?>
		}
	}

</script>
<!-- Stylesheets
============================================= -->
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
<?php
#CSS
foreach ($css_layout as $css) {
echo css_asset($css.'.css');
}
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124365146-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-124365146-1');
</script>
