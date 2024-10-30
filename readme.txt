=== Moo Gravatar Box ===
Logline: Show gravatars in your comments form
Contributors: 3dolab
Homepage: http://www.3dolab.net/en/mootools-gravatar-box
Tags: gravatar, gravbox, 3dolab, javascript, mootools, fading, automatic
Requires at least: 2.8
Tested up to: 3.2
Stable tag: 0.5

Automatically shows a gravatar box in the comment form, based on the MooTools framework.

== Description ==

This plugin auto-detects and shows in real-time the Gravatar image when users are filling the comment form, with a nice fading effect. 
It's fully customizable through the Options page! 
It's a fork of the "Gravatar Box" plugin by Otto42, based on the MooTools javascript framework (instead of jQuery). 

Please note that as of now the code has changed from gravbox() to moo_gravbox(), in order to fulfill a more than reasonable request from Otto.

= Plugin Homepage =

http://www.3dolab.net/en/mootools-gravatar-box

== Installation ==

1. Upload the files to the `/wp-content/plugins/moo-gravatar-box/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add this to your comments form somewhere: 
if (function_exists('moo_gravbox')) moo_gravbox();
1. Add styling for it into your style.css. 
The moo_gravbox() code adds a div with id of "gravbox". 
The image has the "gravatar" class, and is wrapped inside another div with a class of "gravatar_frame".
The no-gravatar link is inside a p with a class of "nogravatar".

Further and more easily configurable options will be available in a near future release.


== Frequently Asked Questions ==

= How can I customize the style? =

The main CSS classes are #gravbox and .gravatar_frame. Tweak them starting from the default rules:

#gravbox {
float:left;
margin-right:6px;
width:96px;
height:96px;
background:url(http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=96.png);
}

#gravbox .avatar {
margin:0;
padding:0;
}

#gravbox .nogravatar {
text-align:center;
font-weight:bold;
}

#gravbox img {
border:1px solid black;
}

= I see no gravatar on my page! =

Possible problems: 

- Did you add the gravbox code to your comments form?

- Are you logged in? Most themes don't display the email box when you're logged in. Log out and look at the page.

- Type in an email address for something to actually happen. The div defaults to empty, until it has something to check.

- Email addresses always contain the @ sign. Without an @, it won't bother checking.

- Can you access gravatar.com normally? The request happens in your browser, not from the website.

= Nothing happens when I type in an email! =

Open your browser's error console. Any javascript errors in there? If so, they may have stopped execution of javascript on the page. Solve those errors. This may involve deactivating other plugins which are broken and causing errors on your page.

= The gravatar it displays is wrong! =

No, it's not. Go login to your gravatar account and check.

== Screenshots ==

1. Gravatar without any data entry
2. Gravatar shows up when email address is entered
3. Link appears when "404" is selected as default avatar

== Changelog ==

= 0.5 (2011.09.21) = 
* Options page added: custom size, images, rating and much more!

= 0.4 = 
* First version
