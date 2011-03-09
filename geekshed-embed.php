<?php
/*
Plugin Name: GeekShed Embed
Plugin URI: http://geekshed.net/
Description: Creates a shortcode to embed a <a href='http://geekshed.net'>GeekShed IRC</a> channel (chatroom) into a page/post
Author: Ryan Murphy
Author URI: http://2skewed.net
Version: 2.0-beta
*/

/*

With the exception of gse_display_js(), the following license applies:

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED `AS IS` AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
*/

//include the shortcode file
include( 'shortcode.php' );


if ( is_admin() ) {
	add_action( 'admin_menu', 'geekshed_embed_menu' );
	add_action( 'admin_init', 'register_gse_settings' );
	add_action( 'admin_notices', 'gse_setup_notice');
}

function geekshed_embed_menu() {
	add_options_page( 'GeekShed Embed Settings', 'GeekShed Embed', 'manage_options', 'geekshed-embed-settings', 'gse_settings_page' ); 
}

function register_gse_settings() {
	register_setting( 'gse_settings', 'gse_channel_name', 'gse_validate_channel' );
	register_setting( 'gse_settings', 'gse_width', 'intval' );
	register_setting( 'gse_settings', 'gse_height', 'intval' );
	register_setting( 'gse_settings', 'gse_chat_only' );
	register_setting( 'gse_settings', 'gse_restricted' );
	register_setting( 'gse_settings', 'gse_user_badge' );
	register_setting( 'gse_settings', 'gse_background_color', 'wp_filter_nohtml_kses' );
	register_setting( 'gse_settings', 'gse_header_color', 'wp_filter_nohtml_kses' );
	register_setting( 'gse_settings', 'gse_chat_page' );
}

function gse_setup_notice() {
	if (get_option( 'gse_channel_name') == '' ) {
		echo '<div id="geekshed-embed-notice" class="updated fade"><p><strong>GeekShed Embed is almost ready.</strong> Please visit the <a href="options-general.php?page=geekshed-embed-settings">settings page</a> in order to use it. Usage instructions are also provided there.</p></div>';
	}
}

//Let's create the settings page now...
function gse_settings_page() { ?>
	<div class='wrap'>
		<?php gse_display_js(); ?>
		<h2>GeekShed Embed</h2>
		<?php gse_display_notes(); ?>
		<h3>Settings</h3>
		<form method='post' action='options.php'>
		<?php settings_fields( 'gse_settings' ); ?>
			<table class='form-table'>
				<tr valign='top'>
					<th scope='row'>Channel Name</th>
					<td>
						<?php $gse_channels = get_option( 'gse_channel_name' );
						$gse_channels = preg_replace( '/^/','#', $gse_channels );
						$gse_channels = str_replace( '%2C%23', ',#', $gse_channels );
						?>
						<input type='text' name='gse_channel_name' value='<?php echo $gse_channels ?>' />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Width</th>
					<td>
						<input type='text' name='gse_width' value='<?php echo get_option("gse_width"); ?>' />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Height</th>
					<td>
						<input type='text' name='gse_height' value='<?php echo get_option("gse_height"); ?>' />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Hide join/part/quit/mode messages</th>
					<td>
						<input type='checkbox' name='gse_chat_only' <?php if( get_option( 'gse_chat_only' ) == true ) echo " checked='checked' "; ?> />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Restrict clients to your channel only</th>
					<td>
						<input type='checkbox' name='gse_restricted' <?php if( get_option( 'gse_restricted' ) == true) echo "checked='checked' "; ?> />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Show usercount badge</th>
					<td>
						<input type='checkbox' name='gse_user_badge' <?php if( get_option( 'gse_user_badge' ) == true) echo "checked='checked' "; ?> />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Background Color</th>
					<td>
						<input type='text' name='gse_background_color' value='<?php echo get_option( "gse_background_color" ); ?>' />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Header Color</th>
					<td>
						<input type='text' name='gse_header_color' value='<?php echo get_option( "gse_header_color" ); ?>' />
					</td>
				</tr>
				<tr valign='top'>
					<th scope='row'>Chat Page</th>
					<td>
						<?php wp_dropdown_pages( array( 'name' => 'gse_chat_page', 'echo' => 1, 'show_option_none' => '&mdash; Select &mdash;', 'option_none_value' => '0', 'selected' => get_option( 'gse_chat_page' ) ) ); ?>
					</td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
		<?php gse_display_usage(); ?>
	</div>

<?php }

function gse_display_notes() { ?>
	<h3>Notes</h3>
	<div class='toggle' style='max-width:650px;text-align:justify;'>
		<p>At the very minimum, please ensure that the channel name field contains at least one channel name. Without this, the plugin will not work correctly! You should still go through the others and make them what you want to be. This will ensure the shortcodes work correctly.</p>
		<p>In addition to the page dropdown in the settings, the plugin includes two shortcodes for embedding the chat: <code>[geekshed]</code> and <code>[geekshed_chat]</code>. <code>[geekshed]</code> is from the first version, and although it still works, it maybe removed in a future update. The prefered way to embed a chatroom is to edit the settings below, and either set a page or use <code>[geekshed_chat]</code>, as it allows for more options to be set.</p>
		<p>Special note for Width and Height: the recommended minimum height is 375, and the recommended width is 500. If you have selected to have the userbadge displayed, you should add 45 to the height (so minimum of 420), as that is the size of the userbadge. If the width is set less than 500, part of the nicklist will be cut off.</p>
	</div>
<?php } 

function gse_display_usage() { ?>

	<h3>Usage</h3>
	<div class='toggle' style='max-width:650px;text-align:justify;'>
		<h4>To Embed A Chat</h4>
		<p>The first thing you should do is create the page you want the chat to appear on. All you need to do if create a title for it - any content you place on it will be overwritten. Next, on this page, fill out the channel(s) you want visitors to connect to (#channel1,#channel2,#channelN), and select the page from the dropdown. You should fill out the remainder of the fields as well when you get a chance.</p>
		<p>If you would rather use the shortcode instead of selected a page, fill out the settings, leaving the page as `Select`. Next, when you go to create the page, use the [geekshed_chat] shortcode. The settings for it will be pulled from the database.</p>
		<p>If you don't want to fill out the settings form at all, there is the <code>[geekshed]</code> shortcode, although it may be removed in future versions in favor of the settings page and <code>[geekshed_chat]</code>. There are three parameters supported by [geekshed]: channel, width, and height. Channel <strong>must</strong> be the first parameter if you specify it. Here's just one example specifying all three parameters: <code>[geekshed yourChannel width=500 height=375]</code>.</p>
		<h4>To Add A Userbadge</h4>
		<p>To add a userbadge, use the <code>[geekshed_badge]</code> shortcode. It accepts one parameter, the name of the channel. So if you want to have the userbadge for #help displayed, you would use <code>[geekshed_badge help]</code> in the post/page/widget you'd like it to be displayed in.</p>
		<h4>To Add A Userlist</h4>
		<p>To have the list of users in the channel displayed, use the <code>[geekshed_list]</code> shortcode, which takes the channel as it's single parameter. Adding <code>[geekshed_list theshed]</code> to a page would list all the users of #theShed to the page.</p>
	</div>
<?php }

function gse_validate_channel($input) {
	$input = str_replace( ',#', '%2C%23', $input );
	$input = str_replace( ',', '%2C%23', $input );// /join #someChannel,0 prevention
	$input = str_replace( '#', '', $input );
	return $input;
}

function gse_chat_page( $content ) {
	global $post;
	$gse_chat_page = get_option( 'gse_chat_page' );
	
	if ($post->ID != $gse_chat_page) {
		return $content;
	}
	else {
		$content = gse_display_chat();
		return $content;
	}
}

add_filter( 'the_content', 'gse_chat_page' );
	
function gse_display_chat() {
	$gse_channel	  = get_option( 'gse_channel_name' );
	$gse_width		  = get_option( 'gse_width' );
	$gse_height		  = ( 'on' == get_option( 'gse_height' ) ) ? '1' : '';
	$gse_chatOnly	  = ( 'on' == get_option( 'gse_chat_only' ) ) ? '1' : '';
	$gse_restricted	  = ( 'on' == get_option( 'gse_restricted' ) ) ? '1': '';
	$gse_userbadge    = ( 'on' == get_option( 'gse_user_badge' ) ) ? '1': '';
	$gse_bgColor	  = get_option( 'gse_background_color' );
	$gse_headerColor  = get_option( 'gse_header_color' );

	$gse_chat1 = '<div name="flashchat" style="height: '.$gse_height.'px; width: '.$gse_width.'px; background-color: #FFFFFF;"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" salign="tl" wmode="transparent"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="';
	$gse_chat2 = '"><param name="quality" value="high"><embed src="';
	$gse_chat3 =  '" allowScriptAccess="always" allowNetworking="all" quality="high" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="100%" height="100%" salign="tl"></embed></object>';
	$gse_embed_url = 'http://flashirc.geekshed.net/tflash.php?embed=1&amp;joinonconnect='.$gse_channel.'&amp;chatonly='.$gse_chatOnly.'&amp;restricted='.$gse_restricted.'&amp;key=&amp;nick=&amp;bgcolor='.$gse_bgColor.'&amp;headercolor='.$gse_headerColor;

	if( $gse_userbadge ) $gse_chat4 = '<div align="center">	<img src="http://usercount.geekshed.net?chan='.$gse_channel.'" />	</div>';
	else $gse_chat4 = '';

	return $gse_chat1 . $gse_embed_url . $gse_chat2 . $gse_embed_url . $gse_chat3 . $gse_chat4 . '</div>';
}

function gse_display_js() { ?>
<script type="text/javascript">
	// Andy Langton's show/hide/mini-accordion - updated 23/11/2009
	// Latest version @ http://andylangton.co.uk/jquery-show-hide
	// License
	// Comments and extra whitespace removed. Uses <button> instead of <a>
	jQuery(document).ready(function() {
		var is_visible = false;
		jQuery('.toggle').prev().append(' <button class="toggleLink button-secondary">Show/Hide</button>');
		jQuery('.toggle').hide();
		jQuery('button.toggleLink').click(function() {
			is_visible = !is_visible;
			jQuery(this).parent().next('.toggle').toggle('slow');
			return false;
		});
	});
</script>
<?php }
?>
