<?php 
function design_board_button(){ 
    $designBoardButton = '<div class="wishlist-designer-board-container">
        <div class="design-board-save-btn-container" data-id='.get_the_id().' data-name="'.get_the_title().'">         
            <i class="fal fa-plus open-board-container" ></i>
        </div>'.
        do_shortcode('[yith_wcwl_add_to_wishlist]')
        .'
    </div>
    '; 
    return $designBoardButton; 
}

add_shortcode('design_board_button_code', 'design_board_button'); 
