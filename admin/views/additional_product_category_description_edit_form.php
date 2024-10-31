<?php
/**

 * The following variables should be defined:
 * $term_meta  {string}  The value of the content text area.
 *
 * @author     TGM Ingeniería Informática <info@tgminformatica.es>
 *
 * @link       http://www.tgminformatica.es
 * @since      1.0.0
 */
?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="additional_description_category_product"><?php echo esc_html( __( 'Additional description', 'read-more-description-link-for-woocommerce' )); ?></label></th>
    <td>
    	<?php
    	$content = $term_meta['additional_description_category_product'] ? $term_meta['additional_description_category_product'] : '';
    	wp_editor( $content, 'additional_description_category_product', array('textarea_rows' => '25', 'textarea_name' => 'term_meta[additional_description_category_product]'));
    	?>
        <p class="description"><?php echo esc_html( __( 'Additional description will show when clicking on Read more link.', 'read-more-description-link-for-woocommerce' )); ?></p>
    </td>
</tr>