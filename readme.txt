=== GeekShed Embed ===

Contributors: RyanMurphy
Tags: geekshed, irc, chat
Requires at least: 2.7.0
Tested up to: 3.0.1
Stable tag: 1.0

Creates a shortcode to easily embed a GeekShed IRC channel (chatroom) into a post or page.

== Description ==

Creates a shortcode to easily embed a [GeekShed IRC](http://geekshed.net) channel into a post or page. Although the plugin currently doesn't offer as many options as the code generator on the GeekShed site, it uses the same embed code you would get from there. Future versions will include the missing options.

Comments, questions suggestions? Post them at

== Installation ==

1. Upload the `GeekShed-Embed` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the `Plugins` menu in WordPress
1. Create a new page or post, and use the shortcode. See below for examples.

== Examples ==
The shortcode currently supports three parameters: channel, width, and height. Any, none, or all can be used, in any combination.

**NOTE:** If the width is less than 500 or the height is less than 375, parts of the chat box will be cut off and not visible. Future versions will fix this issue (and by fix, I mean ignore the user-specified values if that is the case).

<table>
    <tr>
        <td>What You Type</td>
        <td>What You Get</td>
    </tr>
    <tr>
        <td>[geekshed]</td>
        <td>A 500 by 375 chat box that displays the channel list once connected</td>
    </tr>
    <tr>
        <td>[geekshed someChannel]</td>
        <td>A 500 by 375 chat box that joins someChannel once connected.</td>
    </tr>
    <tr>
        <td>[geekshed height=XXX]</td>
        <td>A chat box XXX pixels tall and 500 pixels wide. It will display the channel list once connected.</td>
    </tr>
    <tr>
        <td>[geekshed width=XXX]</td>
        <td>A chat box XXX pixels wide and 375 pixels tall. It will display the channel list once connected.</td>
    </tr>
</table>

== Changelog ==

= 1.0 =
* Initial public release.
* Thanks to [Craighton](http://www.logiclounge.com/) and [eggy](http://blog.eggy.cc) for testing