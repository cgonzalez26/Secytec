<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Post types
 *
 * Registers post types and taxonomies
 *
 * @class 		WC_Post_types
 * @version		2.2.0
 * @package		WooCommerce/Classes/Products
 * @category	Class
 * @author 		WooThemes
 */
class WC_Post_types {

	/**
	 * Hook in methods
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_status' ), 10 );
	}

	/**
	 * Register WooCommerce taxonomies.
	 */
	public static function register_taxonomies() {
		if ( taxonomy_exists( 'product_type' ) ) {
			return;
		}

		do_action( 'woocommerce_register_taxonomy' );

		$permalinks = get_option( 'woocommerce_permalinks' );

		register_taxonomy( 'product_type',
	        apply_filters( 'woocommerce_taxonomy_objects_product_type', array( 'product' ) ),
	        apply_filters( 'woocommerce_taxonomy_args_product_type', array(
	            'hierarchical' 			=> false,
	            'show_ui' 				=> false,
	            'show_in_nav_menus' 	=> false,
	            'query_var' 			=> is_admin(),
	            'rewrite'				=> false,
	            'public'                => false
	        ) )
	    );

		register_taxonomy( 'product_cat',
			apply_filters( 'woocommerce_taxonomy_objects_product_cat', array( 'product' ) ),
			apply_filters( 'woocommerce_taxonomy_args_product_cat', array(
				'hierarchical'          => true,
				'update_count_callback' => '_wc_term_recount',
				'label'                 => __( 'Product Categories', 'woocommerce' ),
				'labels' => array(
						'name'              => __( 'Categorias de Articulos', 'woocommerce' ),
						'singular_name'     => __( 'Categoria de Articulo', 'woocommerce' ),
						'menu_name'         => _x( 'Categorias', 'Admin menu name', 'woocommerce' ),
						'search_items'      => __( 'Buscar Categorias de Articulos', 'woocommerce' ),
						'all_items'         => __( 'Todas Categorias de Articulos', 'woocommerce' ),
						'parent_item'       => __( 'Categoria de Articulo Padre', 'woocommerce' ),
						'parent_item_colon' => __( 'Categoria de Articulo Padre:', 'woocommerce' ),
						'edit_item'         => __( 'Editar Categoria de Articulo', 'woocommerce' ),
						'update_item'       => __( 'Actualizar Categoria de Articulo', 'woocommerce' ),
						'add_new_item'      => __( 'Agregar nueva Categoria de Articulo', 'woocommerce' ),
						'new_item_name'     => __( 'nuevo Nombre Categoria de Articulo', 'woocommerce' )
					),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => array(
					'slug'         => empty( $permalinks['category_base'] ) ? _x( 'product-category', 'slug', 'woocommerce' ) : $permalinks['category_base'],
					'with_front'   => false,
					'hierarchical' => true,
				),
			) )
		);

		register_taxonomy( 'product_tag',
			apply_filters( 'woocommerce_taxonomy_objects_product_tag', array( 'product' ) ),
			apply_filters( 'woocommerce_taxonomy_args_product_tag', array(
				'hierarchical'          => false,
				'update_count_callback' => '_wc_term_recount',
				'label'                 => __( 'Product Tags', 'woocommerce' ),
				'labels'                => array(
						'name'                       => __( 'Etiquetas de Articulos', 'woocommerce' ),
						'singular_name'              => __( 'Etiqueta de Articulo', 'woocommerce' ),
						'menu_name'                  => _x( 'Etiquetas', 'Admin menu name', 'woocommerce' ),
						'search_items'               => __( 'Buscar Etiquetas de Articulos', 'woocommerce' ),
						'all_items'                  => __( 'Todas Etiquetas de Articulos', 'woocommerce' ),
						'edit_item'                  => __( 'Editar Etiqueta de Articulo', 'woocommerce' ),
						'update_item'                => __( 'Actualizar Product Tag', 'woocommerce' ),
						'add_new_item'               => __( 'Agregar Nuevo Product Tag', 'woocommerce' ),
						'new_item_name'              => __( 'Nuevo Nombre de Etiqueta de Articulo', 'woocommerce' ),
						'popular_items'              => __( 'Las Etiquetas de Articulos Populares', 'woocommerce' ),
						'separate_items_with_commas' => __( 'Separar Etiquetasb de Articulos con comas', 'woocommerce'  ),
						'add_or_remove_items'        => __( 'Agregar o remover Product Tags', 'woocommerce' ),
						'choose_from_most_used'      => __( 'Choose from the most used Product tags', 'woocommerce' ),
						'not_found'                  => __( 'Etiquetas de Articulos no encontradas', 'woocommerce' ),
					),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => array(
					'slug'       => empty( $permalinks['tag_base'] ) ? _x( 'product-tag', 'slug', 'woocommerce' ) : $permalinks['tag_base'],
					'with_front' => false
				),
			) )
		);

		register_taxonomy( 'product_shipping_class',
			apply_filters( 'woocommerce_taxonomy_objects_product_shipping_class', array('product', 'product_variation') ),
			apply_filters( 'woocommerce_taxonomy_args_product_shipping_class', array(
				'hierarchical'          => true,
				'update_count_callback' => '_update_post_term_count',
				'label'                 => __( 'Shipping Classes', 'woocommerce' ),
				'labels' => array(
						'name'              => __( 'Shipping Classes', 'woocommerce' ),
						'singular_name'     => __( 'Shipping Class', 'woocommerce' ),
						'menu_name'         => _x( 'Shipping Classes', 'Admin menu name', 'woocommerce' ),
						'search_items'      => __( 'Search Shipping Classes', 'woocommerce' ),
						'all_items'         => __( 'All Shipping Classes', 'woocommerce' ),
						'parent_item'       => __( 'Parent Shipping Class', 'woocommerce' ),
						'parent_item_colon' => __( 'Parent Shipping Class:', 'woocommerce' ),
						'edit_item'         => __( 'Edit Shipping Class', 'woocommerce' ),
						'update_item'       => __( 'Update Shipping Class', 'woocommerce' ),
						'add_new_item'      => __( 'Add New Shipping Class', 'woocommerce' ),
						'new_item_name'     => __( 'New Shipping Class Name', 'woocommerce' )
					),
				'show_ui'               => true,
				'show_in_nav_menus'     => false,
				'query_var'             => is_admin(),
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => false,
			) )
		);

		global $wc_product_attributes;

		$wc_product_attributes = array();

		if ( $attribute_taxonomies = wc_get_attribute_taxonomies() ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( $name = wc_attribute_taxonomy_name( $tax->attribute_name ) ) {

					$label = ! empty( $tax->attribute_label ) ? $tax->attribute_label : $tax->attribute_name;

					$wc_product_attributes[ $name ] = $tax;

					register_taxonomy( $name,
						apply_filters( 'woocommerce_taxonomy_objects_' . $name, array( 'product' ) ),
						apply_filters( 'woocommerce_taxonomy_args_' . $name, array(
							'hierarchical'          => true,
							'update_count_callback' => '_update_post_term_count',
							'labels'                => array(
									'name'              => $label,
									'singular_name'     => $label,
									'search_items'      => sprintf( __( 'Search %s', 'woocommerce' ), $label ),
									'all_items'         => sprintf( __( 'All %s', 'woocommerce' ), $label ),
									'parent_item'       => sprintf( __( 'Parent %s', 'woocommerce' ), $label ),
									'parent_item_colon' => sprintf( __( 'Parent %s:', 'woocommerce' ), $label ),
									'edit_item'         => sprintf( __( 'Edit %s', 'woocommerce' ), $label ),
									'update_item'       => sprintf( __( 'Update %s', 'woocommerce' ), $label ),
									'add_new_item'      => sprintf( __( 'Add New %s', 'woocommerce' ), $label ),
									'new_item_name'     => sprintf( __( 'New %s', 'woocommerce' ), $label )
								),
							'show_ui'               => false,
							'query_var'             => true,
							'capabilities'          => array(
								'manage_terms' => 'manage_product_terms',
								'edit_terms'   => 'edit_product_terms',
								'delete_terms' => 'delete_product_terms',
								'assign_terms' => 'assign_product_terms',
							),
							'show_in_nav_menus'     => apply_filters( 'woocommerce_attribute_show_in_nav_menus', false, $name ),
							'rewrite'               => array(
								'slug'         => ( empty( $permalinks['attribute_base'] ) ? '' : trailingslashit( $permalinks['attribute_base'] ) ) . sanitize_title( $tax->attribute_name ),
								'with_front'   => false,
								'hierarchical' => true
							),
						) )
					);
				}
			}

			do_action( 'woocommerce_after_register_taxonomy' );
		}
	}

	/**
	 * Register core post types
	 */
	public static function register_post_types() {
		if ( post_type_exists('product') ) {
			return;
		}

		do_action( 'woocommerce_register_post_type' );

		$permalinks        = get_option( 'woocommerce_permalinks' );
		$product_permalink = empty( $permalinks['product_base'] ) ? _x( 'product', 'slug', 'woocommerce' ) : $permalinks['product_base'];

		register_post_type( 'product',
			apply_filters( 'woocommerce_register_post_type_product',
				array(
					'labels'              => array(
							'name'               => __( 'Articulos', 'woocommerce' ),
							'singular_name'      => __( 'Articulo', 'woocommerce' ),
							'menu_name'          => _x( 'Articulos', 'Admin menu name', 'woocommerce' ),
							'add_new'            => __( 'Agregar Articulo', 'woocommerce' ),
							'add_new_item'       => __( 'Agregar Nuevo Articulo', 'woocommerce' ),
							'edit'               => __( 'Editar', 'woocommerce' ),
							'edit_item'          => __( 'Editar Articulo', 'woocommerce' ),
							'new_item'           => __( 'Nuevo Articulo', 'woocommerce' ),
							'view'               => __( 'Vista de Articulo', 'woocommerce' ),
							'view_item'          => __( 'Vista de Articulo', 'woocommerce' ),
							'search_items'       => __( 'Buscar Articulos', 'woocommerce' ),
							'not_found'          => __( 'Articulos no encontrados', 'woocommerce' ),
							'not_found_in_trash' => __( 'Articulos no encontrados en Papelera', 'woocommerce' ),
							'parent'             => __( 'Articulo Padre', 'woocommerce' )
						),
					'description'         => __( 'This is where you can add new products to your store.', 'woocommerce' ),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => 'product',
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
					'rewrite'             => $product_permalink ? array( 'slug' => untrailingslashit( $product_permalink ), 'with_front' => false, 'feeds' => true ) : false,
					'query_var'           => true,
					'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'page-attributes' ),
					'has_archive'         => ( $shop_page_id = wc_get_page_id( 'shop' ) ) && get_post( $shop_page_id ) ? get_page_uri( $shop_page_id ) : 'shop',
					'show_in_nav_menus'   => true
				)
			)
		);

		register_post_type( 'product_variation',
			apply_filters( 'woocommerce_register_post_type_product_variation',
				array(
					'label'        => __( 'Variations', 'woocommerce' ),
					'public'       => false,
					'hierarchical' => false,
					'supports'     => false
				)
			)
		);

		wc_register_order_type(
			'shop_order',
			apply_filters( 'woocommerce_register_post_type_shop_order',
				array(
					'labels'              => array(
							'name'               => __( 'Ordenes', 'woocommerce' ),
							'singular_name'      => __( 'Orden', 'woocommerce' ),
							'add_new'            => __( 'Agregar Orden', 'woocommerce' ),
							'add_new_item'       => __( 'Agregar Nueva Orden', 'woocommerce' ),
							'edit'               => __( 'Editar', 'woocommerce' ),
							'edit_item'          => __( 'Editar Orden', 'woocommerce' ),
							'new_item'           => __( 'Nueva Orden', 'woocommerce' ),
							'view'               => __( 'Vista de Orden', 'woocommerce' ),
							'view_item'          => __( 'Vista de Orden', 'woocommerce' ),
							'search_items'       => __( 'Buscar Ordenes', 'woocommerce' ),
							'not_found'          => __( 'Ordenes no encontradas', 'woocommerce' ),
							'not_found_in_trash' => __( 'Ordenes no encontradas en Papelera', 'woocommerce' ),
							'parent'             => __( 'Ordenes Padres', 'woocommerce' ),
							'menu_name'          => _x( 'Ordenes', 'Admin menu name', 'woocommerce' )
						),
					'description'         => __( 'This is where store orders are stored.', 'woocommerce' ),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => 'shop_order',
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'show_in_menu'        => current_user_can( 'manage_woocommerce' ) ? 'woocommerce' : true,
					'hierarchical'        => false,
					'show_in_nav_menus'   => false,
					'rewrite'             => false,
					'query_var'           => false,
					'supports'            => array( 'title', 'comments', 'custom-fields' ),
					'has_archive'         => false,
				)
			)
		);

		wc_register_order_type(
			'shop_order_refund',
			apply_filters( 'woocommerce_register_post_type_shop_order_refund',
				array(
					'label'                      => __( 'Refunds', 'woocommerce' ),
					'capability_type'            => 'shop_order',
					'public'                     => false,
					'hierarchical'               => false,
					'supports'                   => false,
					'exclude_from_orders_screen' => false,
					'add_order_meta_boxes'       => false,
					'exclude_from_order_count'   => true,
					'exclude_from_order_views'   => false,
					'class_name'                 => 'WC_Order_Refund'
				)
			)
		);

		if ( 'yes' == get_option( 'woocommerce_enable_coupons' ) ) {
			register_post_type( 'shop_coupon',
				apply_filters( 'woocommerce_register_post_type_shop_coupon',
					array(
						'labels'              => array(
								'name'               => __( 'Cupones', 'woocommerce' ),
								'singular_name'      => __( 'Cupon', 'woocommerce' ),
								'menu_name'          => _x( 'Cupones', 'Admin menu name', 'woocommerce' ),
								'add_new'            => __( 'Agregar Cupon', 'woocommerce' ),
								'add_new_item'       => __( 'Agregar Nuevo Coupon', 'woocommerce' ),
								'edit'               => __( 'Editar', 'woocommerce' ),
								'edit_item'          => __( 'Editar Cupon', 'woocommerce' ),
								'new_item'           => __( 'Nuevo Cupon', 'woocommerce' ),
								'view'               => __( 'Vista de Cupones', 'woocommerce' ),
								'view_item'          => __( 'Vista de Cupon', 'woocommerce' ),
								'search_items'       => __( 'Buscar Cupones', 'woocommerce' ),
								'not_found'          => __( 'Cupones no encontrados', 'woocommerce' ),
								'not_found_in_trash' => __( 'Cupones no encontrados en Papelera', 'woocommerce' ),
								'parent'             => __( 'Cupon Padre', 'woocommerce' )
							),
						'description'         => __( 'This is where you can add new coupons that customers can use in your store.', 'woocommerce' ),
						'public'              => false,
						'show_ui'             => true,
						'capability_type'     => 'shop_coupon',
						'map_meta_cap'        => true,
						'publicly_queryable'  => false,
						'exclude_from_search' => true,
						'show_in_menu'        => current_user_can( 'manage_woocommerce' ) ? 'woocommerce' : true,
						'hierarchical'        => false,
						'rewrite'             => false,
						'query_var'           => false,
						'supports'            => array( 'title' ),
						'show_in_nav_menus'   => false,
						'show_in_admin_bar'   => true
					)
				)
			);
		}

		register_post_type( 'shop_webhook',
			apply_filters( 'woocommerce_register_post_type_shop_webhook',
				array(
					'label' => __( 'Webhooks', 'woocommerce' ),
					'public'              => false,
					'show_ui'             => false,
					'capability_type'     => 'shop_webhook',
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'show_in_menu'        => false,
					'hierarchical'        => false,
					'rewrite'             => false,
					'query_var'           => false,
					'supports'            => false,
					'show_in_nav_menus'   => false,
					'show_in_admin_bar'   => false,
				)
			)
		);
	}

	/**
	 * Register our custom post statuses, used for order status
	 */
	public static function register_post_status() {
		register_post_status( 'wc-pending', array(
			'label'                     => _x( 'Pending payment', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Pending payment <span class="count">(%s)</span>', 'Pending payment <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-processing', array(
			'label'                     => _x( 'Processing', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Processing <span class="count">(%s)</span>', 'Processing <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-on-hold', array(
			'label'                     => _x( 'On hold', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'On hold <span class="count">(%s)</span>', 'On hold <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-completed', array(
			'label'                     => _x( 'Completado', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-cancelled', array(
			'label'                     => _x( 'Cancelado', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-refunded', array(
			'label'                     => _x( 'Refunded', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Refunded <span class="count">(%s)</span>', 'Refunded <span class="count">(%s)</span>', 'woocommerce' )
		) );
		register_post_status( 'wc-failed', array(
			'label'                     => _x( 'Failed', 'Order status', 'woocommerce' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Failed <span class="count">(%s)</span>', 'Failed <span class="count">(%s)</span>', 'woocommerce' )
		) );
	}
}

WC_Post_types::init();
