<?php
/** 
 * Read more Description link for WooCommerce
 *
 * @package   Read more Description link for WooCommerce
 * @author    TGM Ingeniería Informática<info@tgminformatica.es>
 * @license   GPL-3.0+
 * @link      http://www.tgminformatica.es
 * @copyright 2016 TGM Ingeniería Informática
 */

class ReadMoreDescriptionLink {
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	private function __construct() {

		$additionalDescriptionProductEnabled = get_option( 'wc_show_product_description_read_more_link', 1 );
		$additionalDescriptionProductCategoryEnabled = get_option( 'wc_show_product_category_description_read_more_link', 1 );
		
		if($additionalDescriptionProductEnabled == 'yes')
		{
			add_filter( 'woocommerce_product_tabs', array( $this, 'woo_custom_description_tab' ), 98);
		}
		
		if($additionalDescriptionProductCategoryEnabled == 'yes')
		{
			add_action( 'after_setup_theme', array( $this, 'remove_default_category_description' ), 0);
			add_action( 'woocommerce_archive_description', array( $this, 'woo_custom_category_description' ));
		}
		
		//Add javascript file
		add_action( 'wp_enqueue_scripts', array( $this, 'read_more_link' ));
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	//Change product description, to include the Additional description as "Read more link"
	public function woo_custom_description_tab( $tabs ) {
		$tabs['description']['callback'] = array($this, 'woo_custom_description_tab_content');// Custom description callback
		return $tabs;
	}
	public function woo_custom_description_tab_content() {
		global $product;
		$longProductDescription = wc_format_content($product->post->post_content);
	  	$additionalProductDescription = wc_format_content(get_post_meta( $product->id, '_additional_product_description', true ));
		include 'views/product_description_read_more.php';
	}
	
	//Clear default long category description after load the theme
	public function remove_default_category_description() {
	    remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
	}
	
	//Change category description, to include the Additional description as "Read more link"
	public function woo_custom_category_description() {
	    if ( is_product_category() ) {
	        global $wp_query;
			
			$cat_id = $wp_query->get_queried_object_id();
	        $longProductCategoryDescription = wc_format_content(term_description( $cat_id, 'product_cat' ));
			
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ));
			$termID = $term->term_id;
			$term_data = get_option("taxonomy_$termID");
			$additionalProductCategoryDescription = wc_format_content($term_data['additional_description_category_product']);
			include 'views/product_category_description_read_more.php';
	    }
	}
	
	//Add javascript file
	public function read_more_link() {
	    wp_enqueue_script( 'read_more_link', plugins_url( '/js/read_more_link.js', __FILE__ ));
	}
}
?>