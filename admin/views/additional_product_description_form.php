<?php
/**

 * The following variables should be defined:
 * $val  {string}  The value of the content text area.
 *
 * @author     TGM Ingeniería Informática <info@tgminformatica.es>
 *
 * @link       http://www.tgminformatica.es
 * @since      1.0.0
 */
?>
<p><?php echo esc_html( __( 'Additional description will show when clicking on Read more link.', 'read-more-description-link-for-woocommerce' )); ?></p>
<?php
wp_editor( $val, 'additional_product_description', array('textarea_rows' => '25'));