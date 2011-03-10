<?php
add_shortcode( 'geekshed', 'geekshed_embed' );//leave for back compat
add_shortcode( 'geekshed_chat', 'gse_display_chat' );
add_shortcode( 'geekshed_badge', 'geekshed_badge' );
add_shortcode( 'geekshed_list', 'geekshed_list' );
	
//this is the original function that the plugin had. Would love to get rid of it, but that would be mean. 
function geekshed_embed( $atts ) {
	extract( shortcode_atts( array(
		'channel' => $atts[0],
		'width' => '500',
		'height' => '375' ),
		$atts ));

	$chat1 = '<div name="flashchat" style="height: '.$height.'px; width: '.$width.'px; background-color: #FFFFFF;"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" salign="tl" wmode="transparent"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="';
	$chat2 = '"><param name="quality" value="high"><embed src="';
	$chat3 =  '" allowScriptAccess="always" allowNetworking="all" quality="high" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="100%" height="100%" salign="tl"></embed></object></div>';
	$embed_url = 'http://flashirc.geekshed.net/tflash.php?embed=1&amp;joinonconnect='.$channel.'&amp;chatonly=0&amp;restricted=0&amp;key=&amp;nick=&amp;bgcolor=FFFFFF&amp;headercolor=';

	return $chat1 . $embed_url . $chat2 . $embed_url . $chat3;
}
	
function geekshed_badge( $atts ) {
	extract( shortcode_atts( array(
		'channel' => $atts[0]), $atts));
	return  '<div align="center">	<img src="http://usercount.geekshed.net?chan='.$channel.'" />	</div>';
}

function geekshed_list( $atts ) {
	extract( shortcode_atts( array( 'channel' => $atts[0]), $atts));
	$xml = simplexml_load_file('http://www.geekshed.net/usertable.php?chan='.$channel);
	
	//no idea why the first line needs to be blank, except that if it isn't, <table> doesn't show up... the rest of the code in this block does though :S
	//if I do $content = ''; before this, <table> shows up indented insanely to the right
	$content = <<<EOD

<table>
	<tr>
		<td style='text-align: center;'><strong>Nickname</strong></td>
		<td style='text-align: center;'><strong>Status</strong></td>
		<td style='text-align: center;'><strong>Clones</strong></td>
		<td style='text-align: center;'><strong>Active (Not Away)</strong></td>
	</tr>
EOD;
	foreach ($xml->user as $user) {
		$content = <<<EOD2
		$content
	<tr>
		<td style='text-align: center;'>$user->nick</td>
		<td style='text-align: center;'>$user->status</td>
		<td style='text-align: center;'>$user->clones</td>
		<td style='text-align: center;'>$user->away</td>
	</tr>
EOD2;
	}
	return $content . '</table>';
}
?>
