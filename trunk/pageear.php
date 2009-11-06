<?php
/*
Plugin Name: Page Peel BujanQWorks
Plugin URI: http://herukurniawan.com/2009/11/page-peel-bujanqworks-1-2-wordpress-plugin/
Description: Page Peel is the development BujanQWorkS page peel made by <a href="http://pagepeel-at-webpicasso.de">christian harz </a> for the web - web custum / or homemade. To be used for wordpress without opening the source code embedded in the template file, bind BujanQWorkS this source into a user friendly plugin.
Author: heru kurniawan
Version: 1.2
Author URI: http://herukurniawan.com/
*/
function pageer_header()
{
	pageear_create_table();
?>
<!-- plugin Page Peel BujanQWOrkS 1.2 http://herukurniawan.com/2009/11/page-peel-bujanqworks-1-2-wordpress-plugin/ -->
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
var jumpTo = '<? echo pageear_view_config('url');?>';
// Mirror image ( true | false )
var mirror = '<? echo pageear_view_config('miror');?>'; 
// Color of pagecorner if mirror is false
var pageearColor = '<? echo str_replace('#','',pageear_view_config('color'));?>';  
// Browser target  (new) or self (self)
var openLink = '<? echo pageear_view_config('link');?>';  
</script>
<script src="<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/AC_OETags.js" language="javascript"></script>    
<script src="<? bloginfo('wpurl'); ?>/wp-content/plugins/page-peel-bujanqworks/pageear.js" type="text/javascript"></script>
<!-- end plugin Page Peel BujanQWOrkS 1.2 -->
<?	
}
function pageear_footer()
{
?>
<!-- plugin Page Peel BujanQWOrkS 1.2 http://herukurniawan.com/2009/11/page-peel-bujanqworks-1-2-wordpress-plugin/ -->	
<script type="text/javascript">    
    writeObjects();
</script>
<!-- end plugin Page Peel BujanQWOrkS 1.1 -->
<?
}

function pageear_create_table($small_images='',$large_images='',$url='')
{
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'wp_pageear_bw'"))!=1)
	{
		if($si == '' || $li == '' || $url == '')
		{
			$small_images = get_bloginfo("url")."/wp-content/plugins/page-peel-bujanqworks/pageear_s.jpg";
			$large_images = get_bloginfo("url")."/wp-content/plugins/page-peel-bujanqworks/pageear_b.jpg";
			$url = "http://herukurniawan.com";
		}
		$qry_create_table = "CREATE TABLE `wp_pageear_bw` (
			  `page_id` int(11) NOT NULL auto_increment,
			  `small_image` varchar(500) collate latin1_general_ci NOT NULL,
			  `large_image` varchar(500) collate latin1_general_ci NOT NULL,
			  `version` varchar(6) collate latin1_general_ci NOT NULL default '1.0.0',
			  `url` varchar(500) collate latin1_general_ci NOT NULL default 'http://herukurniawan.com',
			  `miror` varchar(5) collate latin1_general_ci NOT NULL,
			  `color` varchar(6) collate latin1_general_ci NOT NULL,
			  `link` varchar(6) collate latin1_general_ci NOT NULL,
			  
			  
			  PRIMARY KEY  (`page_id`))";
		$result_create_table = mysql_query($qry_create_table);
		
		$qry_insert_table = "INSERT INTO `wp_pageear_bw`(`small_image`,`large_image`,`version`,`url`,`miror`,`color`,`link`)
				VALUES('".$small_images."',
				'".$large_images."', '1.2', 						
				'".$url."','true','#pffffff','new')";
				
		$result_insert_table = mysql_query($qry_insert_table);		
		if($result_create_table && $result_insert_table)
		{
			return 1;
		}
	}	
	else
	{
		$qry_view = "SELECT count(*) FROM wp_pageear_bw WHERE version='1.2'";
		$result_view = mysql_query($qry_view);
		if($field = mysql_fetch_row($result_view))
		{
			if($field[0]==0)
			{
				$qry_view = "SELECT * FROM wp_pageear_bw";
				$result_view = mysql_query($qry_view);
				if($field = mysql_fetch_row($result_view))
				{
					$small_image = $field[1];
					$large_image = $field[2];
					$url         = $field[3];
					
					$qry_drop_table = "DROP TABLE wp_pageear_bw";
					$result_drop = mysql_query($qry_drop_table);
					if($result_drop)
					{
						pageear_create_table($small_image,$large_image,$url);
					}
				}
			}
		}
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
	<h2>Contol Panel Simple PagePeel BujanQWorkS 1.2</h2>
	<table>
		<tr>
			<td>Path Small Image</td>
			<td>:</td>
			<td><input type="text" name="small_image" size="75" value="<? echo pageear_view_config('small_image');?>"></td>
		</tr>
		<tr height="10px"></tr>
		<tr>
			<td>Path Big Image</td>
			<td>:</td>
			<td><input type="text" name="large_image" size="75" value="<? echo pageear_view_config('large_image');?>"></td>
		</tr>
		<tr height="10px"></tr>
		<tr>
			<td>U R L</td>
			<td>:</td>
			<td><input type="text" name="url" size="35" value="<? echo pageear_view_config('url');?>"></td>
		</tr>
		<tr height="10px"></tr>
		<tr>
			<td>Miror</td>
			<td>:</td>
			<td>
			<input type="radio" name="miror" value="true" <? if(pageear_view_config('miror')=='true'){ echo "checked";};?>>Yes 
			<input type="radio" name="miror" value="false" <? if(pageear_view_config('miror')=='false'){ echo "checked";};?>>No 
			</td>
		</tr>
		<tr height="10px"></tr>
		<tr>
			<td>Color</td>
			<td>:</td>
			<td>
		<input type="text" size="10" maxlength="7" name="color"  value="<? echo pageear_view_config('color');?>"  readonly> 
		<a href="#" onclick="showColorPicker(this,document.forms[0].color)"">Color Picker</a></td>
		</tr>
		<tr height="10px"></tr>
		<tr>
			<td>Link Target</td>
			<td>:</td>
			<td>
			<select name="link">
				<option value="self" <? if(pageear_view_config('link')=='self'){ echo "selected";};?>>Self</option>
				<option value="new" <? if(pageear_view_config('link')=='new'){ echo "selected";};?>>New Window</option>
			</select>
		</tr>
		<tr>
			<td><p class="submit"><input type="submit" name="submit_pageear" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" /> </p></td>
		</tr>
	</table>
	</form>
	<hr>
	<p>
	<?
		paypal();
	?>
What is a Page Peel? Page Peel is the banner ads in web corner if we focus on the mouse cursor will display in the ad folding effect that large ads open. And if the ad is clicked will lead to other web pages that show advertisements.<br /><br />

Page Peel is the development BujanQWorkS page peel made by christian Harz for the web - web custum / or homemade. To be used for wordpress without opening the source code embedded in the template file, bind BujanQWorkS this source into a user friendly plugin.
	</p>
	<br /><br /><b>Powered by <a href="http://herukurniawan.com">www.HeruKurniawan.Com</a></b>
	</div>
	<?
}
function pageear_save_config()
{
	$qry_submit = "UPDATE wp_pageear_bw SET 
				   small_image = '".$_POST['small_image']."',
				   large_image = '".$_POST['large_image']."',
				   url = '".$_POST['url']."',
				   miror = '".$_POST['miror']."',
				   color = '".$_POST['color']."',
				   link = '".$_POST['link']."'";
				  
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

function pageear_admin_head()
{
?>
<link rel="stylesheet" href="<? echo get_bloginfo("url"); ?>/wp-content/plugins/page-peel-bujanqworks/js_color_picker_v2.css" media="screen">
<script src="<? echo get_bloginfo("url"); ?>/wp-content/plugins/page-peel-bujanqworks/color_functions.js"></script>		
<script type="text/javascript" src="<? echo get_bloginfo("url"); ?>/wp-content/plugins/page-peel-bujanqworks/js_color_picker_v2.js"></script>
<?
}


function pageear_load() 
{
	add_options_page("PagePeel BW", "PagePeel BW", 1, "PagePeel BW", "pageer_cpanel");
}
	add_action('admin_menu', 'pageear_load');
    add_action('wp_head', 'pageer_header');
    add_action('wp_footer', 'pageear_footer');
	add_action('admin_head', 'pageear_admin_head');
	
function paypal()
{
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
	">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
<?
}
?>
