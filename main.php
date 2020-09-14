<?php
/*Plugin Name: bS Checkout Checkboxes
Plugin URI: https://bootscore.me/
Description: This plugin adds 2 mandatory checkboxes to WooCommerce checkout page and opens the terms and conditions in a new tab.
Version: 1.0.0
Author: Bastian Kreiter
Author URI: https://crftwrk.de
License: GPLv2
*/



/*
// Add custom checkout field: privacy
add_action('woocommerce_review_order_before_submit', 'add_my_checkout_privacy', 9);
  
function add_my_checkout_privacy() {
 //you can change the message here just ensure that the formatting is maintained
echo '<div class="custom-control custom-checkbox"><p class="form-row validate-required"> <input type="checkbox" class="input-checkbox custom-control-input" name="privacy" id="privacy" /> <label for="privacy" class="checkbox custom-control-label">I have read and agree to the website <a href="https://bootscore.me/privacy-policy/" target="_blank">privacy policy</a> <span class="required">*</span></label> </p></div>';
}
 
// tick the box to acknowledge handling time response if not checked
add_action('woocommerce_checkout_process', 'not_privacy_box');
 
function not_privacy_box() {
    if ( ! (int) isset( $_POST['privacy'] ) ) {
// You can edit the message below between the two ' ' for when there is an error eg box not checked
        wc_add_notice( __( 'Please read and accept the privacy policy to proceed with your order.' ), 'error' );
    }
}
// Add custom checkout field: privacy End
*/




// Add custom checkout field for product category: refund
add_action('woocommerce_review_order_before_submit', 'add_bootscore_refund', 9 );
function add_bootscore_refund() {

    $special_cat = 'paid'; // HERE set your special category name, slug or ID
    $bool = false;

    foreach ( WC()->cart->get_cart() as $cart_item ) {
        // compatibility with WC +3
        $product_id = version_compare( WC_VERSION, '3.0', '<' ) ? $cart_item['data']->id : $cart_item['data']->get_id();
        if ( has_term( $special_cat, 'product_cat', $product_id ) ){ 
            $bool = true;
            break; // added this too
        }
    }

    if ( $bool ) {
        //$link = 'https://businessbloomer.com/woocommerce-display-product-specific-tc-checkout/';
        ?>
        <div class="custom-control custom-checkbox">
            <p class="form-row validate-required">
                <input type="checkbox" class="input-checkbox custom-control-input bootscore-refund" name="bootscore-refund" id="refund" />
                <label for="refund" class="checkbox custom-control-label">For digital content: I explicitly agree that we continue with the execution of our contract before expiration of the revocation period. I hereby also declare that I am aware of the fact that I am losing my right of revocation with this agreement. <span class="required">*</span></label>
            </p>
        </div>
<?php
    }
}

// If customer does not agree to terms
add_action('woocommerce_checkout_process', 'not_approved_bootscore_refund');
function not_approved_bootscore_refund() {

    $special_cat = 'paid'; // HERE set your special category name, slug or ID
    $bool = false;

    // Checking again if the category is in one cart item
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        // compatibility with WC +3
        $product_id = version_compare( WC_VERSION, '3.0', '<' ) ? $cart_item['data']->id : $cart_item['data']->get_id();
        if ( has_term( $special_cat, 'product_cat', $product_id ) ){
            $bool = true;
            break; // added this too
        }
    }

    if ( empty( $_POST['bootscore-refund'] ) && $bool )
        wc_add_notice( __( 'You must accept the waiver for your rights of revocation regarding digital content.' ), 'error' );
}
// Add custom checkout field for product category: refund End





// Add custom checkout field: risk
add_action('woocommerce_review_order_before_submit', 'add_my_checkout_risk', 9);
  
function add_my_checkout_risk() {
 //you can change the message here just ensure that the formatting is maintained
echo '<div class="custom-control custom-checkbox"><p class="form-row validate-required"> <input type="checkbox" class="input-checkbox custom-control-input" name="risk" id="risk" /> <label for="risk" class="checkbox custom-control-label">I agree that all software available on this website are provided “as is” without warranty of any kind, either expressed or implied and such software is to be used at my own risk. I made a backup of my page before installing. <span class="required">*</span></label> </p></div>';
}
 
// tick the box to acknowledge handling time response if not checked
add_action('woocommerce_checkout_process', 'not_risk_box');
 
function not_risk_box() {
    if ( ! (int) isset( $_POST['risk'] ) ) {
// You can edit the message below between the two ' ' for when there is an error eg box not checked
        wc_add_notice( __( 'You must accept accept the risk note.' ), 'error' );
    }
}
// Add custom checkout field: risk End





// Open terms and conditions in new tab
function wc_checkout_terms_and_conditions() {
  remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
}
add_action( 'wp', 'wc_checkout_terms_and_conditions' );
// Open terms and conditions in new tab End













