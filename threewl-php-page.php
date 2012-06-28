<?php
/*
Plugin Name: threewl-php-page
Plugin URI: http://www.seo-traffic-guide.de/3WL-PHP-Page-Plugin/
Description: Create a page that contains the <a href="http://www.seo-traffic-guide.de/recommends/3waylinks">3waylinks.net</a> outgoing links for the 3waylinks linking system by Jon Leger <a href="options-general.php?page=threewl-php-page.php">Options configuration panel</a> This plugin is based on the Privacy Page Plugin by Eric Giguere (http://www.synclastic.com/plugins/privacy-policy/)
Version: 0.10
Author: Michael Busch
Author URI: http://www.seo-traffic-guide.de
*/
 
/*
To install:
 
1. Upload threewl-php-page.zip to the /wp-content/plugins/ directory for your blog.
2. Unzip it into /wp-content/plugins/threewl-php-page/threewl-php-page.php
3. Activate the plugin through the 'Plugins' menu in WordPress by clicking "3WL Links Page"
4. Go to your Options Panel and open the "3WL Links Page" submenu. /wp-admin/options-general.php?page=threewl-php-page.php
5. Configure the 3waylinks options you want.

License:

Copyright 2008 by Michael Busch. You are free to use this plugin on 
any WordPress blog. No warranty is provided -- not even that this plugin does what it is intended for
*/

$threewlphppage = '0.10';

$pp_default_threewlid = 'your 3WL site ID';
$pp_default_title = 'Resources';
$pp_default_slug = 'resources';
$pp_default_pp_help = true;
$pp_default_credit = true;

add_option( 'threewl_php_page_threewlid', $pp_default_threewlid );
add_option( 'threewl_php_page_title', $pp_default_title );
add_option( 'threewl_php_page_slug', $pp_default_slug );
add_option( 'threewl_php_page_pp_help', $pp_default_pp_help );
add_option( 'threewl_php_page_credit', $pp_default_credit );
add_option( 'threewl_php_page_credit_link', 0 );
add_option( 'threewl_php_page_activity', 0 );

function threewl_php_page_options_setup() {
    if( function_exists( 'add_options_page' ) ){
        add_options_page( '3WL Links Page', '3WL Links Page', 8, 
                          basename(__FILE__), 'threewl_php_page_options_page');
    }

}

function threewl_php_page_options_page(){
    global $threewl_php_page_ver;
    global $pp_default_threewlid;
    global $pp_default_title;
    global $pp_default_slug;
    global $pp_default_pp_help;
    global $pp_default_credit;

    if( isset( $_POST[ 'set_defaults' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	update_option( 'threewl_php_page_title', $pp_default_title );
	update_option( 'threewl_php_page_threewlid', $pp_default_threewlid );
	update_option( 'threewl_php_page_slug', $pp_default_slug );
	update_option( 'threewl_php_page_pp_help', $pp_default_pp_help );
	update_option( 'threewl_php_page_credit', $pp_default_credit );

	echo 'Default 3WL Links Page options loaded!';
	echo '</strong></p></div>';

    } else if( isset( $_POST[ 'create_page' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	$title = trim(stripslashes( (string) $_POST[ 'threewl_php_page_title' ] ));
	$slug  = trim(stripslashes( (string) $_POST[ 'threewl_php_page_slug' ] ));
	$threewlid = trim(stripslashes( (string) $_POST['threewl_php_page_threewlid' ] ));

	update_option( 'threewl_php_page_title', $title );
	update_option( 'threewl_php_page_threewlid', $threewlid );
	update_option( 'threewl_php_page_slug', $slug );

	$post_title = $title;
	$post_content = '[threewlphppage]';
	$post_status = 'publish';
	$post_author = 1;
	$post_name = $slug;
	$post_type = 'page';

	$post_data = compact( 'post_title', 'post_content', 'post_status',
		              'post_author', 'post_name', 'post_type' );

	$postID = wp_insert_post( $post_data );

	if( !$postID ){
	    echo '3WL Links Page page could not be created';
	} else {
	    echo '3WL Links Page page (ID ' . $postID . ') was created';
	}

	echo '</strong></p></div>';
    } else if( isset( $_POST[ 'info_update' ] ) ){

        echo '<div id="message" class="updated fade"><p><strong>';

	update_option( 'threewl_php_page_threewlid', trim( stripslashes( (string) $_POST['threewl_php_page_threewlid' ] )));
	update_option( 'threewl_php_page_title', trim( stripslashes( (string) $_POST['threewl_php_page_title' ] )));
	update_option( 'threewl_php_page_slug', trim( stripslashes( (string) $_POST['threewl_php_page_slug' ] )));
	update_option( 'threewl_php_page_pp_help', (bool) $_POST['threewl_php_page_pp_help'] );
	update_option( 'threewl_php_page_credit', (bool) $_POST['threewl_php_page_credit'] );

	echo 'Configuration updated!';
	echo '</strong></p></div>';
    }

    ?>

    <div class="wrap">
    <h2>3WL Links Page <?php echo $threewl_php_page_ver; ?></h2>
    <p>The <a href="http://www.seo-traffic-guide.de/3WL-PHP-Page-Plugin/">3WL Links Page Plugin for WordPress</a> automatically generates the 3waylinks 
    links page for the 3waylinks linking system by Jonathan Leger (<a href="http://www.seo-traffic-guide.de/recommends/3waylinks">3WayLinks.net</a>)
    Please note that you have to be a paying member in the 3waylinks system in order to be able use this plugin, although the plugin itself comes free of charge.
    </p>

    <p>To use the plugin, insert the shortcode <strong>[threewlphppage]</strong> into an existing page. The trigger will be
    automatically replaced with a complete 3waylinks link page.</p>
    <p style="color:red">Caution: If you have updated from a plugin version prior to 0.5 you have to change the code on your 3WL links page to this new shortcode!</p>

    <p>For your convenience, the plugin can also create a new links page
    for you. Simply fill in the title and slug (path) details and press
    the "Create Page" button to create the 3WL links page. The trigger text
    will be added automatically to the new page.</p>
    <p style="color:red"><b>If you let the 3WL Links Page Plugin create your site, make sure that you have entered your 3Waylinks ID! Otherwise the page created will not work properly and you might get the warning "bad request" when you try to view the page</b></p>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="info_update" id="info_update" value="true" />

    <fieldset class="options">
    <legend>3Waylinks-ID</legend>

    <table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr valign="top">
      <td align="left" valign="middle">Your 3Waylinks Site ID 
         <input name="threewl_php_page_threewlid" type="text" size="20" 
                value="<?php echo htmlspecialchars( get_option( 'threewl_php_page_threewlid' ) ); ?>" />
      </td>
    </tr>

    </table>

    </fieldset>

    <fieldset class="options">
    <legend>Options</legend>

    <ul>

    <li><label for="threewl_php_page_credit">
      <input type="checkbox" name="threewl_php_page_credit"
             id="threewl_php_page_credit"
             <?php echo ( get_option( 'threewl_php_page_credit' ) == true ? "checked=\"checked\"" : "" ) ?> />
	     Include credit link for the 3WL Links Page Plugin for WordPress (thank you!)
    </label></li>

    </ul>

    </fieldset>

    <div class="submit">
      <input type="submit" name="set_defaults" value="<?php _e('Load Default Options'); ?> &raquo;" />
      <input type="submit" name="info_update" value="<?php _e('Update options' ); ?> &raquo;" />
    </div>

    <fieldset class="options">
    <legend>Page Creation</legend>

    <table width="100%" border="0" cellspacing="0" cellpadding="6">

    <tr valign="top">
      <td align="right" valign="middle"><strong>Page Title</strong></td>
      <td align="left" valign="middle">
         <input name="threewl_php_page_title" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'threewl_php_page_title' ) ); ?>" />
      </td>
    </tr>

    <tr valign="top">
      <td align="right" valign="middle"><strong>Page Slug</strong></td>
      <td align="left" valign="middle">
         <input name="threewl_php_page_slug" type="text" size="40" 
                value="<?php echo htmlspecialchars( get_option( 'threewl_php_page_slug' ) ); ?>" />
      </td>
    </tr>

    </table>

    </fieldset>

    <div class="submit">
      <input type="submit" name="create_page" value="Create Page" />
    </div>

    </form>
    
    </div><?php
}

// [threewlphppage]
function threewlphppage_func($atts) {
	extract(shortcode_atts(array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts));

	$sitename = get_option( 'threewl_php_page_sitename' );
	$link_pp_help = get_option( 'threewl_php_page_pp_help' );
	$link_credit = get_option( 'threewl_php_page_credit' );
	$threewlid = get_option('threewl_php_page_threewlid');

 
	if(!isset($_GET["article"])){
		$_GET["article"] = "";
	}
	$getparamsserialized = urlencode(serialize($_GET));
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
	curl_setopt($ch, CURLOPT_URL, "http://3waylinks.net/links.php?id=$threewlid&incode=1&article=$_GET[article]&pagevar=$_GET[nu]&g=" . $getparamsserialized);
	$pp = curl_exec($ch);
	curl_close($ch);
 
	if( $link_credit ){
		$creditlink = get_option('threewl_php_page_credit_link');
		if (!$creditlink) {
			$creditlink = get_html_creditlink();
			update_option ('threewl_php_page_credit_link', $creditlink);
		}
	$pp .= '<br><br><p style="color:grey;font-size:8px">This links page was generated with help of www.seo-traffic-guide.de ('
. $creditlink .').</p>'
	. "\n";
	}

	return $pp;
}
add_shortcode('threewlphppage', 'threewlphppage_func');

// this piece of code is still here for compatibility reasons - will be removed in one of the next versions...
function threewl_php_page_process($content) {

    $tag = "<!-- threewl_php_page -->";
	
    // Quickly leave if nothing to replace
    
    if( strpos( $content, $tag ) == false ) return $content;

    // Otherwise generate the 3WL links PHP3WL links PHP3WL links PHP and sub it in

    return str_replace( $tag, threewl_php_page_html(), $content );
}

function threewl_php_page_html(){
	$sitename = get_option( 'threewl_php_page_sitename' );
	$link_pp_help = get_option( 'threewl_php_page_pp_help' );
	$link_credit = get_option( 'threewl_php_page_credit' );
	$threewlid = get_option('threewl_php_page_threewlid');

	if(!isset($_GET["article"])){
	$_GET["article"] = "";
	}
	$getparamsserialized = urlencode(serialize($_GET));
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
	curl_setopt($ch, CURLOPT_URL, "http://3waylinks.net/links.php?id=$threewlid&incode=1&article=$_GET[article]&pagevar=$_GET[nu]&g=" . $getparamsserialized);
	$pp = curl_exec($ch);
	curl_close($ch);
 
    if( $link_credit ){
	$creditlink = get_option('threewl_php_page_credit_link');
	if (!$creditlink) {
		$creditlink = get_html_creditlink();
		update_option ('threewl_php_page_credit_link', $creditlink);
	}

        $pp .= '<br><br><p style="color:grey;font-size:8px">This links page was generated with help of www.seo-traffic-guide.de ('
	    . $creditlink .').</p>'
	    . "\n";
    }

    return $pp;
}

function get_html_creditlink()
{
        global $threewlphppage;
        $twldomain=$_SERVER["HTTP_HOST"];

        if (function_exists("curl_init")) {
                $_WPC_ch = curl_init();

                curl_setopt($_WPC_ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($_WPC_ch, CURLOPT_ENCODING, "");
                curl_setopt($_WPC_ch, CURLOPT_HTTPGET, true);
                curl_setopt($_WPC_ch, CURLOPT_URL, "http://twlcontrol.seo-traffic-guide.de/output.php?ver=$threewlphppage&domain=$twldomain");

                $twlcreditlink = @curl_exec($_WPC_ch);

                curl_close($_WPC_ch);
        } else
		$twlcreditlink = @file_get_contents("http://twlcontrol.seo-traffic-guide.de/output.php?ver=$threewlphppage&domain=$twldomain");

        return $twlcreditlink;
}


function checkRefreshDate($refreshdate)
{
        #returns true if the last refresh date has been longer ago than 3 weeks
        
        if($refreshdate < (time()-(60*60*24*21)))
        {
        return true;
        }
        else
        {
        return false;
        }
} 

function updateCreditLink()
{
	if (checkRefreshDate(get_option('threewl_php_page_activity'))) {
		update_option('threewl_php_page_credit_link', 0);
		update_option('threewl_php_page_credit_refresh', time());
    	}
	if ( ! $_GET['updatePoweredByCaption']) {
       		return;
	}
        $resetpoweredby = $_GET['updatePoweredByCaption'];
 
	if ( $resetpoweredby == get_bloginfo('url') ) {
        	update_option('threewl_php_page_credit_link', 0);
	}
    exit;        
}


add_filter('the_content', 'threewl_php_page_process');

add_action('admin_menu', 'threewl_php_page_options_setup');
add_action('wp', 'updatecreditlink');


?>
