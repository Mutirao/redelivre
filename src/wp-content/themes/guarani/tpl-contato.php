<?php
/**
 * The template for the Contact page.
 *
 * @package Guarani
 * @since Guarani 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php if ( get_option( 'campanha_contact_enabled' ) ) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Contact Us', 'guarani' ); ?></h1>
						</header><!-- .entry-header -->
					
						<div class="entry-content">
							<?php
							
							if ( $contact_text = get_option( 'campanha_contact_page_text' ) )
								echo '<p>' . nl2br( $contact_text ) . '</p>';
							
							if ( function_exists( 'campanha_the_contact_form' ) )
								campanha_the_contact_form();
							?>
							
							<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'guarani' ), 'after' => '</div>' ) ); ?>
							<a class="post-edit-link" href="<?php echo admin_url( 'admin.php?page=campaign_contact' ); ?>"><span class="edit-link"><?php _e( 'Edit', 'guarani' ); ?></span></a>
						</div><!-- .entry-content -->
					</article><!-- #post-<?php the_ID(); ?> -->

					<?php comments_template( '', true ); ?>

				<?php endif; // end of conditional. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>