<?php
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),

    );
}
/////////////////////////////////////////////////
function mon_premier_post_type()
{

    $args = array(

        'labels' => array(
            'name' => 'Cars',
            'singular_name' => 'Car',
            'add_new_item'  =>  'Ajouter une nouvelle voiture',
            'add_new'       => 'Ajouter',
		    'edit_item'     => 'Editer la voiture',
		    'update_item'   => 'Modifier la voiture',
            
        ),

        'public' => true,
        'has_archive' => true,
        'hierarchical'        => true,
        'rewrite'              => array('slug' => 'cars'),
        'supports'            => array('title', 'editor', 'thumbnail'),
        'menu_icon'           => 'dashicons-car',
        'menu_position' => 4,
    );

    register_post_type('cars', $args);
}
add_action('init', 'mon_premier_post_type',0);
/////////////////////////////////////////////////

function ma_premiere_taxonomy()
{
    $args = array(
        'labels' => array(
            'name' => 'Marques',
            'singular_name' => 'Marque',
            'add_new_item'  => 'Ajouter une nouvelle marque',
            'add_new'       => 'Ajouter',
		    'edit_item'     => 'Editer la marque',
		    'update_item'   => 'Modifier la marque',
        ),
        'public' => true,
        'hierarchical' => false,

    );
    register_taxonomy('marques', array('cars'), $args);

    $args = array(
        'labels' => array(
            'name' => 'Roues',
            'singular_name' => 'Roue',
            'add_new_item'  => 'Ajouter une nouvelle roue',
            'add_new'       => 'Ajouter',
		    'edit_item'     => 'Editer la roue',
		    'update_item'   => 'Modifier la roue',
        ),
        'public' => true,
        'hierarchical' => true,
        
    
    );
    register_taxonomy('Roues', array('cars'), $args);

}
add_action('init', 'ma_premiere_taxonomy');


add_shortcode('ballon', 'quel_ballon');
function quel_ballon()
{
    return "<h2>ballonwwwwww</h2>";
}


/////////////////////////////////////////////////
// Afficher toutes les occurences
function recent_posts_shortcode($atts, $content = null)
{
        $atts = shortcode_atts(
        array(
            'posts' => '',
        ),
        $atts,
        'recent-posts'
    );

    
    $the_query = new WP_Query(array('posts_per_page' => $atts['posts']));

   
    $output = '<ul>';
    while ($the_query->have_posts()) :
        $the_query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    endwhile;
    $output .= '</ul>';

    
    wp_reset_postdata();

   
    return $output;
}
add_shortcode('recent-posts', 'recent_posts_shortcode');
/////////////////////////////////////////////////

function be_dps_default_image($output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class, $author, $category_display_text)
{
    if (!empty($original_atts['image_size']) && !empty($original_atts['default_image']) && empty($image)) {
        $default_image_id = intval($original_atts['default_image']);
        if ($original_atts['include_link']) {
            $image = '<a class="image" href="' . get_permalink() . '">' . wp_get_attachment_image($default_image_id, $original_atts['image_size']) . '</a> ';
        } else {
            $image = '<span class="image">' . wp_get_attachment_image($default_image_id, $original_atts['image_size']) . '</span> ';
        }

        if (!empty($image))
            $output = '<' . $inner_wrapper . ' class="' . implode(' ', $class) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . '</' . $inner_wrapper . '>';
    }
    return $output;
}
add_filter('display_posts_shortcode_output', 'be_dps_default_image', 10, 11);

/////////////////////////////////////////////////

// Afficher  les 5 dernières  occurences
function five_recent_posts_shortcode($atts, $content = null)
{
    $atts = shortcode_atts(
        array(
            'posts' => '5',
        ),
        $atts,
        'recent-posts'
    );

    
    $the_query = new WP_Query(array('posts_per_page' => $atts['posts']));

   
    $output = '<ul>';
    while ($the_query->have_posts()) :
        $the_query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    endwhile;
    $output .= '</ul>';

    
    wp_reset_postdata();

   
    return $output;
}
add_shortcode('five_recent-posts', 'five_recent_posts_shortcode');