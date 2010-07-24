<?php
/*
Plugin Name: GeekShed Embed
Plugin URI: http://geekshed.net/
Description: Creates a shortcode to embed a <a href="http://geekshed.net">GeekShed IRC</a> channel (chatroom) into a page/post
Author: Ryan Murphy
Author URI: http://2skewed.net
Version: 1.0
*/

/*

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED “AS IS” AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
*/

    function geekshed_embed($atts) {

        extract(shortcode_atts(array(
            'channel' => '',
            'width' => '500',
            'height' => '375'),
            $atts));
        $html1 = '<div name="flashchat" style="height: '.$height.'px; width: '.$width.'px; background-color: #FFFFFF;"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" salign="tl" wmode="transparent"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="';
        $html2 = '"><param name="quality" value="high"><embed src="';
        $html3 =  '" allowScriptAccess="always" allowNetworking="all" quality="high" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" width="100%" height="100%" salign="tl"></embed></object></p></div><p>';
        $embed_url = 'http://flashirc.geekshed.net/tflash.php?embed=1&amp;joinonconnect='.$atts[0].'&amp;chatonly=0&amp;restricted=0&amp;key=&amp;nick=&amp;bgcolor=FFFFFF&amp;headercolor=';

        return $html1 . $embed_url . $html2 . $embed_url . $html3;
    }

    add_shortcode('geekshed', 'geekshed_embed');
?>