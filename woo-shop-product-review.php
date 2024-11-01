<?php	/**
		Plugin Name: Woo Shop Product Review Popup
		Description: Woo Shop Product Review Popup
		Version: 2.0.0
		Author: TheWPexperts 
		Author URI: http://www.thewpexperts.com/ 
		License: GPL 2.0
		Text Domain: woocommerce
	 */

function woo_shop_product_review_link() {
	global $post;
    echo '<a class="button demo_button openform" id="'.$post->ID.'" href="javascript:void(0);">Add Review</a>';
}
add_action( 'woocommerce_after_shop_loop_item', 'woo_shop_product_review_link', 20 );
function woo_shop_product_review_popup()
{
    if (is_shop()){
        wp_enqueue_script('jquery-fancybox-js', plugins_url('fancybox/jquery.fancybox.js', __FILE__ )); 
        wp_enqueue_style('review-form-css', plugins_url('assets/css/custom.css', __FILE__ )); 
		wp_enqueue_style('jquery-fancybox-css', plugins_url('fancybox/jquery.fancybox.css', __FILE__ ));
		wp_register_script('review-custom-js', plugins_url('assets/custom.js', __FILE__ ),array('jquery'));
		wp_localize_script( 'review-custom-js', 'reviewAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));   
		wp_enqueue_script('review-custom-js');	 	
		?> 
	<?php 
	}
}
add_action('wp_head', 'woo_shop_product_review_popup');
add_action('wp_footer', 'woo_shop_product_review_popup_html');
function woo_shop_product_review_popup_html()
{
    if (is_shop()){
		?> 
		<div class="formClass"></div>
	<?php 
	}
}
add_action('init', 'woo_shop_product_review_popup');
add_action("wp_ajax_woo_shop_product_review_form", "woo_shop_product_review_form");
add_action("wp_ajax_nopriv_woo_shop_product_review_form", "woo_shop_product_review_form");
function woo_shop_product_review_form() {
global $woocommerce,$product; 
$proID = sanitize_text_field($_REQUEST['productID']);
$product = new WC_Product($proID);
?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title"><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
				/* translators: 1: reviews count 2: product name */
				printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title($proID) . '</span>' );
			} else {
				_e( 'Reviews', 'woocommerce' );
			}
		?></h2>
<div id="review_form">
   <div id="respond" class="comment-respond">
      <form action="<?php echo home_url(); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form" novalidate="">
         <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span></p>
         <p class="comment-form-rating">
            <label for="rating">Your Rating</label>
            <select name="rating" id="rating" >
               <option value="">Rate…</option>
               <option value="5">Perfect</option>
               <option value="4">Good</option>
               <option value="3">Average</option>
               <option value="2">Not that bad</option>
               <option value="1">Very Poor</option>
            </select>
         </p>
         <p class="comment-form-comment"><label for="comment">Your Review <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required=""></textarea></p>
         <p class="comment-form-author"><label for="author">Name <span class="required">*</span></label> <input id="author" name="author" value="" size="30" aria-required="true" required="" type="text"></p>
         <p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input id="email" name="email" value="" size="30" aria-required="true" required="" type="email"></p>
         <p class="form-submit"><input name="submit" id="submit" class="submit" value="Submit" type="submit"> <input name="comment_post_ID" value="<?php echo $proID; ?>" id="comment_post_ID" type="hidden">
            <input name="comment_parent" id="comment_parent" value="0" type="hidden">
         </p>
      </form>
   </div>
   <!-- #respond -->
</div>
<div class="clear"></div>
</div>
<?php die();} 
