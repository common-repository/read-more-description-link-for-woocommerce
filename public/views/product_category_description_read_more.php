<?php
/**

 * The following variables should be defined:
 * $longProductCategoryDescription  {string}  Default long category description.
 * $additionalProductCategoryDescription  {string}  New additional category description.
 *
 * @author     TGM Ingeniería Informática <info@tgminformatica.es>
 *
 * @link       http://www.tgminformatica.es
 * @since      1.0.0
 */
 
if(empty($additionalProductCategoryDescription))
{
	echo wp_kses_post($longProductCategoryDescription);
}
else
{?>
	<div class="itemProductCategoryDescription">
		<?php echo wp_kses_post($longProductCategoryDescription); ?>
		<p><a href="#" id="lnk_more" class="lnk_more_cat"><?php echo esc_html( __( 'Read more', 'read-more-description-link-for-woocommerce' )); ?></a></p>
	</div>
	<div id="more" class="itemProductCategoryDescription" style="display:none;">
		<?php echo wp_kses_post($additionalProductCategoryDescription); ?>
		<p><a href="#" id="lnk_hide" class="lnk_more_cat close_cat"><?php echo esc_html( __( 'Hide', 'read-more-description-link-for-woocommerce' )); ?></a></p>
	</div>
<?php
}?>