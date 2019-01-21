<?php
/**
 * Template Name: Email Cat
 */

add_action( 'genesis_loop', 'custom_category_loop' );
/**
 * Custom loop that display a list of categories with corresponding posts.
 */
function custom_category_loop() {
 // Grab all the categories from the database that have posts.
 $categories = get_terms( 'category', 'orderby=name&include=19' );
 // Loop through categories
 foreach ( $categories as $category ) {
 // Display category name
//  echo '<h2 class="post-title">' . $category->name . '</h2>';
 echo '<h2 class="post-title">Articles</h2>';
 echo '<div class="post-list">';
 // WP_Query arguments
 $args = array(
 'cat' => $category->term_id,
 'orderby' => 'term_order',
 );
 // The Query
 $query = new WP_Query( $args );
 // The Loop
 if ( $query->have_posts() ) {
 while ( $query->have_posts() ) {
 $query->the_post();
 ?>
 <p><a href="<?php the_permalink();?>"><?php the_title(); ?></a></p>
 <?php
 } // End while
 } // End if
 echo '</div>';
 // Restore original Post Data
 wp_reset_postdata();
 } // End foreach
}
// Start the engine.
genesis();