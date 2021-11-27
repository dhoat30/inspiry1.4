 <?php 
get_header(); 

    ?>
    
   
<!--Trending section  ----->


<section class="trending-section  margin-row row-container">
    
    <div class="title-container flex-row flex-start align-end">
        <h1 class="section-font-size">Trending Now</h1>  
        <h2 class="poppins-font medium-font-size thin">What we’re covering most this season</h2>                                
    </div>                                   
    
    <div class="flex flex-row owl-carousel">

        <?php 

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
                ?>
        
            <a class="cards rm-txt-dec"  href="<?php echo get_the_permalink();?>">
            
         
                    <img loading="lazy" src="<?php echo get_the_post_thumbnail_url(null,"woocommerce_thumbnail"); ?>"
                            alt="Khroma">
                    <div class="paragraph-font-size margin-top upper-case"  id="trending-now" ><?php echo get_the_title();?> <i class="fal fa-angle-right"></i></div>
              
            </a>
    
        <?php 

            }
            wp_reset_postdata();
            ?>
    </div>
</section>
    
    <?php 

  while(have_posts()){
    the_post(); 
    ?>
    <div class="body-contaienr contact-page">
        <img class="hero-section-img" alt="Contact us" src="<?php echo  get_site_url();?>/wp-content/uploads/2020/11/CONTACT-PAGE.jpg">
        <div class="row-container contact-us-page">
            <div class="column contact-form">
                <?php //the_content();?>
            </div>
            
            <div class="column contact">
                <div class="contact-info">
                    <div class="phone">
                        <a href="tel:08004677479" class="rm-txt-dec"><i class="fas fa-phone-alt"></i> 0800 INSPIRY (467 7479)
                        </a>                   
                    </div>
                    <div class="email">
                        <a href="mailto:hello@inspiry.co.nz" class="rm-txt-dec"><i class="fas fa-envelope"></i> hello@inspiry.co.nz</a>
                    </div>
                    <div class="chat">
                        <a href="#" class="rm-txt-dec"><i class="fas fa-comment-dots"></i> Live Chat</a>
                    </div>
                    <div class="business-hours">
                        <a href="#" class="rm-txt-dec"><i class="fas fa-clock"></i> Monday - Friday: 9:00am - 4:30pm </a>
                    </div>
                </div>

                <div class="social-media">
                    <h4 class="column-font-size regular">Get social with us</h4>
                    <div class="underline-dg"></div>
                    <div class="social-media-container">
                        <a href="https://www.facebook.com/inspiryliveaninspiredlife/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="" target="_blank"><i class="fab fa-instagram-square"></i></a>
                        <a href="" target="_blank"><i class="fab fa-pinterest-square"></i></a>
                        <a href="" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
      </div>
      <div>

      </div>
    </div>
    
   
    <?php
}
?>

<?php
get_footer();
?> 