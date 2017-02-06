<?php

function register_button($buttons) {
	$buttons[] = 'blockquote_link';

	return $buttons;
}
add_filter('mce_buttons', 'register_button');

function mce_plugin($plugin_array) {
	$plugin_array['custom_button_script'] = get_stylesheet_directory_uri().'/myeditor_plugin/myeditor_plugin.js';

	return $plugin_array;
}
add_filter('mce_external_plugins', 'mce_plugin');
