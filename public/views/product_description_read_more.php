<?php
/**

 * The following variables should be defined:
 * $longDescription  {string}  Default long product description.
 * $additionalProductDescription  {string}  New additional product description.
 *
 * @author     TGM Ingeniería Informática <info@tgminformatica.es>
 *
 * @link       http://www.tgminformatica.es
 * @since      1.0.0
 */

if(empty($additionalProductDescription))
{
	echo wp_kses_post($longProductDescription);
}
else
{?>
	<div class="itemProductDescription">
		<?php echo wp_kses_post($longProductDescription); ?>
		<p><a href="#" id="lnk_more" class="lnk_more_cat"><?php echo esc_html( __( 'Read more', 'read-more-description-link-for-woocommerce' )); ?></a></p>
	</div>
	<div id="more" class="itemProductDescription" style="display:none;">
		<?php echo wp_kses_post($additionalProductDescription); ?>
		<p><a href="#" id="lnk_hide" class="lnk_more_cat close_cat"><?php echo esc_html( __( 'Hide', 'read-more-description-link-for-woocommerce' )); ?></a></p>
	</div>
<?php
}?>