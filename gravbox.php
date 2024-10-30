<?php
/*
Plugin Name: Moo Gravatar Box
Plugin URI: http://www.3dolab.net/en/mootools-gravatar-box
Description: Automatically shows a gravatar box in the comment form, based on the MooTools framework
Author: 3dolab
Version: 0.5
Author URI: http://www.3dolab.net
License: GPL2

    Copyright 2011  3dolab  (email: boss@3dolab.net)
    credits to Otto (otto@ottodestruct.com or http://ottopress.com) for the original Gravatar Box (jQuery) plugin

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/
$version = '0.5';
register_activation_hook(__FILE__,'moo_gravbox_install');
function moo_gravbox_install() {
	get_option('moo_gravbox_defopt')=='' ? update_option( 'moo_gravbox_defopt', 0 ) : $default_options;
	get_option('moo_gravbox_size')=='' ? update_option( 'moo_gravbox_size', '80' ) : $size;
	get_option('moo_gravbox_rating')=='' ? update_option( 'moo_gravbox_rating', 'g' ) : $avatar_rating;
	get_option('moo_gravbox_defimg')=='' ? update_option( 'moo_gravbox_defimg', 'mm' ) : $default_image;
	get_option('moo_gravbox_custom')=='' ? update_option( 'moo_gravbox_custom', '' ) : $custom_img;
	get_option('moo_gravbox_forcedef')=='' ? update_option( 'moo_gravbox_forcedef', 0 ) : $force_default;
	get_option('moo_gravbox_secure')=='' ? update_option( 'moo_gravbox_secure', 0 ) : $secure;
	//get_option('moo_gravbox_fx')=='' ? update_option( 'moo_gravbox_fx', '1' ) : $effect;
	get_option('moo_gravbox_duration')=='' ? update_option( 'moo_gravbox_duration', 400 ) : $fx_duration;
}

add_action('wp_print_scripts','moo_gravbox_load');
function moo_gravbox_load() {
	// only bother to load stuff on pages where the comment box is likely to be
	if (is_singular() || is_comments_popup()) {
		wp_register_script('moocore',WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/mootools-1.2.5-core-yc.js', false, '1.2');
		wp_enqueue_script('moocore');
		wp_enqueue_script('string-utf8', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/string.utf8.js',array('moocore'), '1.0');
		wp_enqueue_script('string-md5', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/string.md5.js',array('string-utf8'), '1.0');
		wp_enqueue_script('moo-gravbox', WP_PLUGIN_URL . '/'.dirname( plugin_basename(__FILE__)).'/moo-gravbox.js',array('string-md5'), '1.0');
		if (get_option('moo_gravbox_defimg') != 'custom')
			$default_avatar = get_option('moo_gravbox_defimg');
		else
			$default_avatar = urlencode(get_option('moo_gravbox_custom'));
		if (get_option('moo_gravbox_defopt') != 1)
			$script_options = array(
				'size' => get_option('moo_gravbox_size'),
				'rating' => get_option('moo_gravbox_rating'),
				'default_image' => $default_avatar,
				'force_default' => get_option('moo_gravbox_forcedef'),
				'secure' => get_option('moo_gravbox_secure'),
				//'effect' => get_option('moo_gravbox_fx'),
				'fx_duration' => get_option('moo_gravbox_duration')
				);
		else
			$script_options = array(
				'size' => get_option('moo_gravbox_size'),
				'rating' => get_option('avatar_rating'),
				'default_image' => get_option('avatar_default'),
				'force_default' => get_option('moo_gravbox_forcedef'),
				'secure' => get_option('moo_gravbox_secure'),
				//'effect' => get_option('moo_gravbox_fx'),
				'duration' => get_option('moo_gravbox_duration')
				);
		wp_localize_script( 'moo-gravbox', 'MooGravBoxParams', $script_options );
	}
}

function moo_gravbox() {
	if (is_user_logged_in()) {
		$user = wp_get_current_user();
		echo '<div id="gravbox"><div class="gravatar_frame">';
		echo get_avatar( $user->id, get_option('moo_gravbox_size') );
		echo '</div></div>';
	} else {
		echo '<div id="gravbox"></div>';
	}
}

add_action('comment_form_before_fields','moo_gravbox');

add_action('admin_menu', 'moo_gravbox_options');

function moo_gravbox_options() {
	//$mypage = add_options_page('Moo Gravatar Box', 'Moo Gravatar Box', 8, 'mootools-gravatar-box/gravbox.php', 'moo_gravbox_optionsPage');
	//add_action( "admin_print_scripts-$mypage", 'add_admin_js' );
  if (function_exists('add_options_page')) {
	add_options_page('Moo Gravatar Box', 'Moo Gravatar Box', 8, dirname( plugin_basename(__FILE__)).'/gravbox.php', 'moo_gravbox_optionsPage');
  }
}
function moo_gravbox_optionsPage() {
	global $_POST;
	if( $_POST['moo_gravbox_update'] == 1 ) {
			update_option( 'moo_gravbox_defopt', $_POST['moo_gravbox_defopt'] );
			update_option( 'moo_gravbox_size', $_POST['moo_gravbox_size'] );
			update_option( 'moo_gravbox_rating', $_POST['moo_gravbox_rating'] );
			update_option( 'moo_gravbox_defimg', $_POST['moo_gravbox_defimg'] );
			update_option( 'moo_gravbox_custom', $_POST['moo_gravbox_custom'] );
			update_option( 'moo_gravbox_forcedef', $_POST['moo_gravbox_forcedef'] );
			update_option( 'moo_gravbox_secure', $_POST['moo_gravbox_secure'] );
			//update_option( 'moo_gravbox_fx', $_POST['moo_gravbox_fx'] );
			update_option( 'moo_gravbox_duration', $_POST['moo_gravbox_duration'] );
			$content.='<div class="updated"><p><strong>'.__('Options saved.').'</strong></p></div>';
	}
		$default_options = get_option('moo_gravbox_defopt');
		$size = get_option('moo_gravbox_size');
		//$avatar_rating = get_option('moo_gravbox_rating');
		//$default_image = get_option('moo_gravbox_defimg');
		$custom_img = get_option('moo_gravbox_custom');
		$force_default = get_option('moo_gravbox_forcedef');
		$secure = get_option('moo_gravbox_secure');
		//$effect = get_option('moo_gravbox_fx');
		$fx_duration = get_option('moo_gravbox_duration');
		$content.='
			<h2>Moo Gravatar Box Plugin Options</h2>
			<p>remember to put in your comment template the PHP code <code>if (function_exists(\'moo_gravbox\')) moo_gravbox();</code></p>
			<form name="moo_gravbox_settings" method="post" action="'. str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">
				<input type="hidden" name="moo_gravbox_update" value="1">
				<div>
						<h3>'.__('Fade Effect Duration').'</h3>
						<legend class="screen-reader-text"><span>'.__('Fade Effect Duration').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_duration">'.__('Duration in ms of the image fading effect').'</label>
						<input name="moo_gravbox_duration" type="text" id="moo_gravbox_duration" value="' .$fx_duration . '" size="8" /> ms
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Avatar Size').'</h3>
						<legend class="screen-reader-text"><span>'.__('Avatar Size').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_size">'.__('Allowed values: from 1px up to 512px (default is 80x80px if no parameter is supplied)').'</label>
						<input name="moo_gravbox_size" type="text" id="moo_gravbox_size" value="' .$size . '" size="8" /> px
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Default Options').'</h3>
						<legend class="screen-reader-text"><span>'.__('Default Options').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_defopt">'.__('Use general Wordpress').' <a href="'.admin_url( 'options-discussion.php' ).'">'.__('discussion options').'</a> '.__('for Avatars').__(' (the following settings will be ignored)').'</label>
						';
						$default_options==1 ? $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_defopt" id="moo_gravbox_defopt" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_defopt" id="moo_gravbox_defopt" value="1">';
		$content.='
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Maximum Rating').'</h3>
						<legend class="screen-reader-text"><span>'.__('Maximum Rating').'</span></legend>
						<label style="width: 350px; display: block; margin-right:10px;" for="moo_gravbox_rating">'.__('Appropriate image for your audience').'</label>';
		$ratings = array(
				/* translators: Content suitability rating: http://bit.ly/89QxZA */
				'g' => __('G &#8212; Suitable for all audiences'),
				/* translators: Content suitability rating: http://bit.ly/89QxZA */
				'pg' => __('PG &#8212; Possibly offensive, usually for audiences 13 and above'),
				/* translators: Content suitability rating: http://bit.ly/89QxZA */
				'r' => __('R &#8212; Intended for adult audiences above 17'),
				/* translators: Content suitability rating: http://bit.ly/89QxZA */
				'x' => __('X &#8212; Even more mature than above')
			);
		foreach ($ratings as $key => $rating) :
			$selected = (get_option('moo_gravbox_rating') == $key) ? 'checked="checked"' : '';
			$content.='
				<label><input type="radio" name="moo_gravbox_rating" value="' . esc_attr($key) . '" '.$selected.'/> '.$rating.'</label><br />';
		endforeach;
		$content.='
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Default Avatar').'</h3>
						<legend class="screen-reader-text"><span>'.__('Default Avatar').'</span></legend>
						<label style="width: 350px; display: block; margin-right:10px;" for="moo_gravbox_defimg">'.__('For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their e-mail address.').'</label>';

		$avatar_defaults = array(
			'mm' => __('Mystery Man'),
			'blank' => __('Blank'),
			'gravatar_default' => __('Gravatar Logo'),
			'identicon' => __('Identicon (Generated)'),
			'wavatar' => __('Wavatar (Generated)'),
			'monsterid' => __('MonsterID (Generated)'),
			'retro' => __('Retro (Generated)'),
			'404' => __('HTTP 404 (None)'),
			'custom' => __('Custom (enter URL below)')
		);
		$avatar_defaults = apply_filters('avatar_defaults', $avatar_defaults);
		$default = get_option('moo_gravbox_defimg');
		if ( empty($default) )
			$default = 'mm';
		$size = 32;
		$avatar_list = '';
		foreach ( $avatar_defaults as $default_key => $default_name ) {
			$selected = ($default == $default_key) ? 'checked="checked" ' : '';
			$avatar_list .= "\n\t<label><input type='radio' name='moo_gravbox_defimg' id='avatar_{$default_key}' value='" . esc_attr($default_key)  . "' {$selected}/> ";

			$avatar = get_avatar( $user_email, $size, $default_key );
			$avatar_list .= preg_replace("/src='(.+?)'/", "src='\$1&amp;forcedefault=1'", $avatar);

			$avatar_list .= ' ' . $default_name . '</label>';
			$avatar_list .= '<br />';
		}
		$content.= apply_filters('default_avatar_select', $avatar_list);

		$content.='
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Custom Image').'</h3>
						<legend class="screen-reader-text"><span>'.__('Custom Image').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_custom">'.__('URL to a custom default image').'</label>
						<input name="moo_gravbox_custom" type="text" id="moo_gravbox_custom" value="' .$custom_img . '" size="50" />
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Force Default').'</h3>
						<legend class="screen-reader-text"><span>'.__('Force Default').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_forcedef">'.__('Force the default image to always load').'</label>
						';
		$force_default==1 ? $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_forcedef" id="moo_gravbox_forcedef" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_forcedef" id="moo_gravbox_forcedef" value="1">';
		$content.='
						<div style="clear: both"></div>
				</div>
				<div>
						<h3>'.__('Secure Requests').'</h3>
						<legend class="screen-reader-text"><span>'.__('Secure Requests').'</span></legend>
						<label style="width: 350px; display: block; float:left; margin-right:10px;" for="moo_gravbox_secure">'.__('Serve Gravatars via SSL').'</label>
						';
		$secure==1 ? $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_secure" id="moo_gravbox_secure" value="1" checked>' : $content.='<input style="float: left;" type="checkbox" name="moo_gravbox_secure" id="moo_gravbox_secure" value="1">';
		$content.='
						<div style="clear: both"></div>
				</div>
			<hr />
			<p class="submit"><input type="submit" name="Submit" value="Update Options" /></p>
			</form>';
	echo $content;
}