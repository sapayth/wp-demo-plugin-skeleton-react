<?php

function demo_plugin_get_admin_capability() {
	return apply_filters( 'demo_plugin_admin_capabilities', 'manage_options' );
}