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

class ReadMoreDescriptionLink_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	private function __construct() {
		//Plugin Settings
		add_filter( 'woocommerce_get_settings_products', array( $this, 'woo_all_settings' ), 10, 2);
		
		$additionalDescriptionProductEnabled = get_option( 'wc_show_product_description_read_more_link', 1 );
		$additionalDescriptionProductCategoryEnabled = get_option( 'wc_show_product_category_description_read_more_link', 1 );
		
		if($additionalDescriptionProductEnabled == 'yes')
		{
			add_action('add_meta_boxes', array( $this, 'add_additional_product_description' ) );
			add_action('save_post', array( $this, 'save_additional_product_description' ) );
		}
		
		if($additionalDescriptionProductCategoryEnabled == 'yes')
		{
			add_action('product_cat_add_form_fields', array( $this, 'add_additional_category_description_add_product_category' ) );
			add_action('product_cat_edit_form_fields', array( $this, 'add_additional_category_description_edit_product_category' ) );
			add_action('edited_product_cat', array( $this, 'save_additional_category_description' ) );
			add_action('create_product_cat', array( $this, 'save_additional_category_description' ) );
		}

		register_activation_hook( __FILE__, array($this, 'woocommerce_description_read_more_link_activate' ));
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

	//Add Additional description box in Edit product
	public function add_additional_product_description() {
	  add_meta_box(
	    'additional_description',
	    esc_html( __( 'Additional Description', 'read-more-description-link-for-woocommerce' )),
	    array($this,'print_additional_description_meta_box'), 
	    'product',
	    'normal', 
	    'high'
	  );
	}
	
	public function print_additional_description_meta_box( $post ) {
	  $post_id = $post->ID;
	  $val = get_post_meta( $post_id, '_additional_product_description', true );
	  include 'views/additional_product_description_form.php';
	}
	
	//Save product additional description value
	public function save_additional_product_description($post_id) {
	  //If it is saving automatically, we don't do nothing.
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	    return;
	  }
	  // If our textare is not available, we don't do nothing.
	  if ( ! isset( $_REQUEST['additional_product_description'] ) ) {
	    return;
	  }
	  //Retrieve field value and clean it for security
	  $texto = wp_kses_post(trim($_REQUEST['additional_product_description']));
	  //Save data in the personalized field "_additional_product_description"
	  update_post_meta( $post_id, '_additional_product_description', $texto );
	}
	
	//Add Additional description box in Add category product
	public function add_additional_category_description_add_product_category() {
	    include 'views/additional_product_category_description_add_form.php';
	}
	
	//Add Additional description box in Edit category product
	public function add_additional_category_description_edit_product_category($term) {
	    //Getting term ID
		$term_id = $term->term_id;
	
	    //Retrieve the existing value(s) for this meta field. This returns an array
	    $term_meta = get_option("taxonomy_" . $term_id);
		include 'views/additional_product_category_description_edit_form.php';
	}
	
	// Save additional category description callback function.
	public function save_additional_category_description($term_id) {
	    if (isset($_POST['term_meta'])) {
	        $term_meta = get_option("taxonomy_" . $term_id);
	        $cat_keys = array_keys($_POST['term_meta']);
	        foreach ($cat_keys as $key) {
	            if (isset($_POST['term_meta'][$key])) {
	                $term_meta[$key] = $_POST['term_meta'][$key];
	            }
	        }
	        // Save the option array.
	        update_option("taxonomy_" . $term_id, $term_meta);
	    }
	}
	
	//Register options on plugin activation
	public function woocommerce_description_read_more_link_activate() {
	  add_option( 'wc_show_product_description_read_more_link', 'yes' );
	  add_option( 'wc_show_product_category_description_read_more_link', 'yes' );
	}
	
	
	//Plugin Settings
	public function woo_all_settings( $settings, $current_section ) {
		//Check the current section is what we want
		if ( $current_section == 'display' ) {
			$updated_settings = array();
		    
		    $new_settings = array(
				array( 
					'name' => __( 'Product and Category description Read More link', 'read-more-description-link-for-woocommerce' ),
					'type' => 'title','desc' => '',
					'id' => 'description_read_more_link' ),
				
				array(
					'name' => __( 'Show additional product description', 'read-more-description-link-for-woocommerce' ),
					'desc' => __( 'Enable Additional Description and show Read More link in Product Description Tab.', 'read-more-description-link-for-woocommerce' ),
					'tip'  => '',
					'id'   => 'wc_show_product_description_read_more_link',
					'css'  => '',
					'std'  => 'yes',
					'type' => 'checkbox',
				),
				
				array(
					'name' => __( 'Show additional product category description', 'read-more-description-link-for-woocommerce' ),
					'desc' => __( 'Enable Additional Description and show Read More link in Product Category section.', 'read-more-description-link-for-woocommerce' ),
					'tip'  => '',
					'id'   => 'wc_show_product_category_description_read_more_link',
					'css'  => '',
					'std'  => 'yes',
					'type' => 'checkbox',
				),
		
				array( 'type' => 'sectionend', 'id' => 'description_read_more_link' ),
			);
			
			$updated_settings = array_merge( $settings, $new_settings );
		
		    return $updated_settings;
		
		//If not, return the standard settings
		}
		else {
			return $settings;
		}
	}
}
?>