<?php
/*
Plugin Name: Page Peel BujanQWorks
Plugin URI: http://herukurniawan.com/2009/09/page-peel-bujanqworks-1-1-wordpress-plugin/
Description: Plugin ini dikembangkan dari source program yang dibuat oleh <a href="http://pagepeel-at-webpicasso.de">christian harz </a> yang dipergunakan secara manual, dengan adanya plugin ini kita tidak perlu mencopy secara manual code - code yang diberikannya.
Author: heru kurniawan
Version: 1.1
Author URI: http://herukurniawan.com/
*/
function pageer_header()
{
	pageear_create_table();
?>
<!-- plugin Page Peel BujanQWOrkS 1.1 http://herukurniawan.com/2009/09/page-peel-bujanqworks-1-1-wordpress-plugin/ -->
<script type="text/javascript"> 	
// URL to small image 
var pagearSmallImg = '<? echo pageear_view_config('small_image');?>'; 
// URL to small pageear swf
var pagearSmallSwf = '<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/pageear_s.swf'; 
// URL to big image
var pagearBigImg = '<? echo pageear_view_config('large_image');?>'; 
// URL to big pageear swf
var pagearBigSwf = '<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/pageear_b.swf';
// URL to open on pageear click
var jumpTo = '<? echo pageear_view_config('url');?>' 
</script>
<script src="<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/AC_OETags.js" language="javascript"></script>    
<script src="<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/pageear.js" type="text/javascript"></script>
<!-- end plugin Page Peel BujanQWOrkS 1.1 -->
<?	
}
function pageear_footer()
{
?>
<!-- plugin Page Peel BujanQWOrkS 1.1 http://herukurniawan.com/2009/09/page-peel-bujanqworks-1-1-wordpress-plugin/ -->	
<script type="text/javascript">    
    writeObjects();
</script>
<!-- end plugin Page Peel BujanQWOrkS 1.1 -->
<?
}

function pageear_create_table()
{
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'wp_pageear_bw'"))!=1)
	{
		$qry_create_table = "CREATE TABLE `wp_pageear_bw` (
			  `page_id` int(11) NOT NULL auto_increment,
			  `small_image` varchar(500) collate latin1_general_ci NOT NULL,
			  `large_image` varchar(500) collate latin1_general_ci NOT NULL,
			  `version` varchar(6) collate latin1_general_ci NOT NULL default '1.0.0',
			  `url` varchar(500) collate latin1_general_ci NOT NULL default 'http://herukurniawan.com',
			  PRIMARY KEY  (`page_id`))";
		$result_create_table = mysql_query($qry_create_table);
		
		$qry_insert_table = "INSERT INTO `wp_pageear_bw`(`small_image`,`large_image`,`version`,`url`)
				VALUES('".get_bloginfo("url")."/wp-content/plugins/page-peel-bujanqworks/pageear_s.jpg',
				'".get_bloginfo("url")."/wp-content/plugins/page-peel-bujanqworks/pageear_b.jpg', '1.1', 'http://herukurniawan.com')";
		$result_insert_table = mysql_query($qry_insert_table);		
		if($result_create_table && $result_insert_table)
		{
			return 1;
		}
	}	
	else
	{
		return 0;
	}	
}
////////// CONTROL PANEL /////////////
function pageer_cpanel()
{
	pageear_create_table();
	if($_POST['submit_pageear']){ pageear_save_config(); 
	?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
	<?}
	?>
	<div class="wrap">
	<form method="post" action="<? echo $_SERVER["REQUEST_URI"] ?>">
	<h2>Contol Panel Simple PagePeel BujanQWorkS 1.0</h2>
	<table>
		<tr>
			<td>Path Small Image</td>
			<td>:</td>
			<td><input type="text" name="small_image" size="75" value="<? echo pageear_view_config('small_image');?>"></td>
		</tr>
		<tr>
			<td>Path Big Image</td>
			<td>:</td>
			<td><input type="text" name="large_image" size="75" value="<? echo pageear_view_config('large_image');?>"></td>
		</tr>
		<tr>
			<td>U R L</td>
			<td>:</td>
			<td><input type="text" name="url" size="35" value="<? echo pageear_view_config('url');?>"></td>
		</tr>
		<tr>
			<td><p class="submit"><input type="submit" name="submit_pageear" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" /> </p></td>
		</tr>
	</table>
	</form>
	</div>
	<?
}
function pageear_save_config()
{
	$qry_submit = "UPDATE wp_pageear_bw SET 
				   small_image = '".$_POST['small_image']."',
				   large_image = '".$_POST['large_image']."',
				   url = '".$_POST['url']."'";
				  
	$result_submit = mysql_query($qry_submit);
	if($result_submit)
	{
			return 1;
	}			   
	else
	{
			return 0;
	}
}

function pageear_view_config($field)
{
		$qry_view = "SELECT ".$field." FROM wp_pageear_bw LIMIT 1";
		$result_view = mysql_query($qry_view);
		if($field = mysql_fetch_row($result_view))
		{
			return $field[0];
		}
}
function pageear_load() 
{
	add_options_page("Simple Pagepeel", "Simple Pagepeel", 1, "Simple Pagepeel", "pageer_cpanel");
}
	add_action('admin_menu', 'pageear_load');
    add_action('wp_head', 'pageer_header');
    add_action('wp_footer', 'pageear_footer');
?>
