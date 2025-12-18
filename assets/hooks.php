<?php     
//-----------------------------------
function appetiser_header_hook_function() { ?>  
<script>var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';</script>       
<?php }   
add_action( 'wp_head', 'appetiser_header_hook_function' );   