<?php

namespace DemoPlugin\Admin;

class Page {
	const POST_TYPE = 'page';

	/**
	 * @var array|\WP_Post|null $current holds the current page
	 */
	private $current;

	public function __construct( $id = 0 ) {
		if ( $id !== 0 ) {
			$this->current = get_post( $id );
		} else {
			$this->current = null;
		}
	}

	/**
	 * Get the products to show in the products list
	 *
	 * @return array
	 */
	public function all() {
		$formatted_list = [];
		$child_pages    = [];
		$all_pages      = get_pages( [ 'sort_column' => 'ID' ] );

		if ( empty( $all_pages ) ) {
			return [
				'success' => true,
				'pages'   => [],
			];
		}

		foreach ( $all_pages as $page ) {
			$page->id = $page->ID;

			if ( ! empty( $page->post_parent ) ) {
				$child_pages[ $page->post_parent ][] = $page;
			} else {
				$formatted_list[ $page->ID ] = $page;
			}
		}

		foreach ( $child_pages as $parent_id => $page ) {
			$formatted_list[ $parent_id ]->children = $page;
		}

		return [
			'success'     => true,
			'pages'       => array_values( $formatted_list ),
			'total_pages' => count( $all_pages ),
		];
	}

	public function trash() {
		if ( $this->current ) {
			return wp_trash_post( $this->current->ID );
		}

		return [
			'success' => false,
		];
	}
}
