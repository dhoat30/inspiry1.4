<?php
/**
 * WooCommerce Order Status Manager
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Order Status Manager to newer
 * versions in the future. If you wish to customize WooCommerce Order Status Manager for your
 * needs please refer to http://docs.woocommerce.com/document/woocommerce-order-status-manager/ for more information.
 *
 * @author      SkyVerge
 * @copyright   Copyright (c) 2015-2020, SkyVerge, Inc. (info@skyverge.com)
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * Default customer order status email template.
 *
 * Note: the .td class used in table is from WooCommerce core (see email-styles.php).
 *
 * @type string $email_heading The email heading.
 * @type string $email_body_text The email body.
 * @type \WC_Order $order The order object.
 * @type bool $sent_to_admin Whether email is sent to admin.
 * @type bool $plain_text Whether email is plain text.
 * @type bool $show_download_links Whether to show download links.
 * @type bool $show_purchase_note Whether to show purchase note.
 * @type \WC_Email $email The email object.
 *
 * @since 1.0.0
 * @version 1.10.0
 */
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<!-- body  -->
<div class="body max-width padding">
        <div class="text-content">
        <?php 
                    
                    $dateString = get_post_meta( $order->id, 'back_order_date', true );
                  
                    $date =  DateTime::createFromFormat('Ymd', $dateString);
                ?>
                
            <!-- tracking number -->
            <p class="paragraph">Dear <?php echo $order->get_shipping_first_name();?>, Thank you for placing an order with Inspiry. We appreciate your business. Due to the current situation with Covid, we are experiencing delays. 
            <br><br>
            Your order will be available on <strong> <?php echo $date->format('d-m-Y');?></strong> and it is being placed on back order. We sincerely apologise for delay. And once it is been shipped, we will send you a Tracking Number. We trust that it is suitable to you. Your support and trust in us is most appreciated. 
           <br><br>
           Please don’t hesitate to contact us at hello@inspiry.co.nz. 
            <!-- only for when item is shipped  -->
            
            
            <!-- only for when item is shipped  -->
            
          
        </div>
    </div>


<?php do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );


/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );

 ?>
