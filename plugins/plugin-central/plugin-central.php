<?php
/*
Plugin Name: Plugin Central
Plugin URI: http://www.prelovac.com/vladimir/wordpress-plugins/plugin-central
Description: Receive dashboard plugin update notifications with changelogs, update all plugins at once, move your plugins from one blog to another.
Version: 2.5
Author: Vladimir Prelovac
Author URI: http://www.prelovac.com/vladimir/

Copyright 2008  Vladimir Prelovac
*/

if (isset($plugin_central)) return false;

require_once(dirname(__FILE__) . '/plugin-central.class.php');

$plugin_central = new PluginCentral();