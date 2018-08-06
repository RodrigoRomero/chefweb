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


<meta property="og:locale"			   content="es_ES" />
<meta property="og:url"                content="<?php echo base_url()?>" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="<?php echo $this->evento->nombre ?>" />
<meta property="og:site_name"          content="<?php echo $this->evento->nombre?>" />
<meta property="og:description"        content="<?php echo $this->evento->bajada?>" />
<meta property="og:image"              content="<?php echo image_asset_url('av2020_og.jpg', '','') ?>" />
<meta property="og:image:width"        content="1200" />
<meta property="og:image:height"       content="627" />

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


<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Facebook Pixel Code -->
<script>
/*!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1748104025451888');
fbq('track', 'PageView');*/

</script>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50805014-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50805014-1');
</script>
