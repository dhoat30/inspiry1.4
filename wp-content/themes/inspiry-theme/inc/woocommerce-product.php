<?php

// add product custom field
// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields()
{
  
    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => '_supplier_name',
            'placeholder' => 'Add Supplier Name',
            'label' => __('Supplier Name', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );
    //Custom Product Number Field
    woocommerce_wp_text_input(
        array(
            'id' => '_product_cost',
            'placeholder' => 'Add Product Cost',
            'label' => __('Product Cost', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            )
        )
    );
    
    echo '</div>';
}

function woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Text Field
    $woocommerce_custom_supplier_name = $_POST['_supplier_name'];
    if (!empty($woocommerce_custom_supplier_name))
        update_post_meta($post_id, '_supplier_name', esc_attr($woocommerce_custom_supplier_name));
// Custom Product Number Field
    $woocommerce_product_cost = $_POST['_product_cost'];
    if (!empty($woocommerce_product_cost))
        update_post_meta($post_id, '_product_cost', esc_attr($woocommerce_product_cost));
}

// related product loop 
add_action('woocommerce_after_single_product_summary', 'relatedProductLoop', 30); 

function relatedProductLoop(){ 
echo '<section class="trending-section  margin-row row-container">'; 
   echo  '<div class="flex flex-row related-product-section owl-carousel">'; 
        $argsLoving = array(
            'post_type' => 'product',
            'posts_per_page'=>10,
                'orderby' => 'date', 
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => array( 'wood-wallpaper-brick-amp'),
                    )
                    ), 
        );
        $loving = new WP_Query( $argsLoving );

        while($loving->have_posts()){ 
            $loving->the_post(); 
           

       echo  '<a class="cards rm-txt-dec" href="';
        echo get_the_permalink();
        echo '">'; 

        echo '<img loading="lazy" src="'; 
        echo  get_the_post_thumbnail_url(null,"woocommerce_thumbnail");
        echo '" alt="Khroma">
        <div class="paragraph-font-size margin-top upper-case"  id="trending-now" >
        '; 
        
                       
         echo get_the_title();
         echo ' <i class="fal fa-angle-right"></i>
         </div>
         </a>'; 
        }
        wp_reset_postdata();
       
   echo "</div>"; 
   echo "</section>"; 
   
}

// single product page wishlist container and add brand name before title 
add_action("woocommerce_single_product_summary", "single_product_page_title_start", 1); 

function single_product_page_title_start(){ 
    global $product; 
    // find the brand name of the product
    $brand = array_shift( wc_get_product_terms( $product->id, 'pa_brands', array( 'fields' => 'names' ) ) );

    echo  '<div class="single-product-before-title-container">';
        echo '<div class="poppins-font brand-name">'; 
        echo $brand; 
        echo '</div>';
        echo '<div class="design-board-container">'. do_shortcode('[design_board_button_code]').'</div>';
    echo '</div>';
}

// single product page share container 
add_action("woocommerce_single_product_summary", "share_code_after_cart", 50); 

//add availabilty and share options
function share_code_after_cart(){ 
    echo '<div class="margin-elements">';
    do_action('add_availability_share'); 
    echo '</div>';
}

// product loop page - add design board buttons 
add_action('woocommerce_before_shop_loop_item_title', 'loop_product_design_board_buttons', 5); 

function loop_product_design_board_buttons(){
    echo do_shortcode('[design_board_button_code]');
}