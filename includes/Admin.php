<?php

namespace DemoPlugin;

use WeDevs\WpUtils\ContainerTrait;

class Admin {
	use ContainerTrait;

	public function __construct() {
		$this->dashboard = new Admin\Dashboard();
		$this->menu      = new Admin\Menu();
	}
}
