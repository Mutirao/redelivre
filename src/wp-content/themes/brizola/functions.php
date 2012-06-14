<?php 
/*
 * IMPORTANTE
 * substituir todos os brizola pelo slug do projeto
 */

include dirname(__FILE__).'/includes/congelado-functions.php';
include dirname(__FILE__).'/includes/html.class.php';
include dirname(__FILE__).'/includes/utils.class.php';
//include dirname(__FILE__).'/includes/form.class.php';


add_action( 'after_setup_theme', 'brizola_setup' );
function brizola_setup() {

    load_theme_textdomain('brizola', TEMPLATEPATH . '/languages' );

    // POST THUMBNAILS
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size( 200, 150, true );

    //REGISTRAR AQUI TODOS OS TAMANHOS UTILIZADOS NO LAYOUT
    //add_image_size('nome',X,Y);
    //add_image_size('nome2',X,Y);

    // AUTOMATIC FEED LINKS
    add_theme_support('automatic-feed-links');

    // CUSTOM IMAGE HEADER
    define('HEADER_TEXTCOLOR', '0033CC');
    define('HEADER_IMAGE_WIDTH', 940); 
    define('HEADER_IMAGE_HEIGHT', 198);

    add_custom_image_header( 'brizola_custom_header', 'brizola_admin_custom_header' );

    // CUSTOM BACKGROUND
    add_custom_background();
}


// admin_bar removal
//wp_deregister_script('admin-bar');
//wp_deregister_style('admin-bar');
remove_action('wp_footer','wp_admin_bar_render',1000);
function remove_admin_bar(){
   return false;
}
add_filter( 'show_admin_bar' , 'remove_admin_bar');

// JS
add_action('wp_print_scripts', 'brizola_addJS');
function brizola_addJS() {
    if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
    
    wp_enqueue_script('jquery-autocomplete', get_stylesheet_directory_uri().'/js/jquery-ui-1.8.20-autocomplete.js', array('jquery-ui-widget'));
    wp_enqueue_script('congelado', get_stylesheet_directory_uri().'/js/congelado.js', 'jquery-autocomplete');
    
    wp_localize_script('congelado', 'vars', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
    
    wp_enqueue_style('jquery-autocomplete',get_stylesheet_directory_uri().'/css/jquery-ui-1.8.20.custom.css');
}

// CUSTOM MENU
add_action( 'init', 'brizola_custom_menus' );
function brizola_custom_menus() {
    register_nav_menus( array(
        'main' => 'Principal',
        'quick-links' => 'Acesso Rápido',
    ) );
}

// SIDEBARS
if(function_exists('register_sidebar')) {
    // sidebar 
    register_sidebar( array(
        'name' =>  'Sidebar',
        'description' => __('Sidebar', 'brizola'),
        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content clearfix">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ) );
}

// EXCERPT MORE

add_filter('utils_excerpt_more_link', 'brizola_utils_excerpt_more',10,2);
function brizola_utils_excerpt_more($more_link, $post){
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'brizola') . '</a>';
}


add_filter( 'excerpt_more', 'brizola_auto_excerpt_more' );
function brizola_auto_excerpt_more( $more ) {
    global $post;
    return '...<br /><a class="more-link" href="'. get_permalink($post->ID) . '">' . __('Continue reading &raquo;', 'brizola') . '</a>';
}

// SETUP
if (!function_exists('brizola_custom_header')) :

    function brizola_custom_header() {
        ?>
        <style type="text/css">
            #branding { background: url(<?php header_image(); ?>); }
			<?php if ( 'blank' == get_header_textcolor() ) : ?>
				#branding h1, #branding p { display: none; }        
			<?php else: ?>       
				#branding, #branding a, #branding a:hover { color: #<?php header_textcolor(); ?>; }
				#branding a:hover { text-decoration: none; }
				#description { filter: alpha(opacity=60); opacity: 0.6; }
			<?php endif; ?>        
        </style>
        <?php
    }

endif;

if (!function_exists('brizola_admin_custom_header')) :

    function brizola_admin_custom_header() {
        ?><style type="text/css">
        
           #headimg {
                padding:55px 0;
                width: 940px !important;
                height: 88px !important;
                min-height: 88px !important;
            }
        
            #headimg h1 {
                font-size:42px;
                line-height:66px;
                margin-bottom: 0px;          
            }
        
            #headimg h1 a {
                text-decoration: none !important;
            }
        
            #headimg #desc { 
                font-size: 16px; 
                margin: 0 10px;
                filter: alpha(opacity=60);
                opacity: 0.6;
            }

        </style><?php
    }

endif;

// COMMENTS
if (!function_exists('brizola_comment')):

    function brizola_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class("clearfix"); ?> id="comment-<?php comment_ID(); ?>">
            <p class="comment-meta alignright bottom">
                <?php comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])) ?> <?php edit_comment_link( __('Edit', 'brizola'), '| ', ''); ?>          
            </p>    
            <p class="comment-meta bottom">
                <?php printf( __('By %s on %s at %s.', 'brizola'), get_comment_author_link(), get_comment_date(), get_comment_time()); ?>
                <?php if($comment->comment_approved == '0') : ?><br/><em><?php _e('Your comment is awaiting moderation.', 'brizola'); ?></em><?php endif; ?>
            </p>
            <?php echo get_avatar($comment, 66); ?>
            <div class="content">
                <?php comment_text(); ?>
            </div>
        </li>
        <?php
    }

endif; 




// custom admin login logo
function custom_login_logo() {
	echo '
        <style type="text/css">
	        .login h1 a { background-image: url('. html::getImageUrl('logo.png') .'); }
        </style>';
}
add_action('login_head', 'custom_login_logo');

function new_headertitle($url){
    return get_bloginfo('sitetitle');
}
add_filter('login_headertitle','new_headertitle');

function custom_login_headerurl($url) {
    return get_bloginfo('url');

}
add_filter ('login_headerurl', 'custom_login_headerurl');
