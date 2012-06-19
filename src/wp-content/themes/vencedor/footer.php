	<footer id="main-footer" class="wrap clearfix">
		<?php wp_nav_menu( array( 'theme_location' => 'rodape', 'container' => false, 'menu_id' => 'footer-nav', 'menu_class' =>'col-8 clearfix', 'fallback_cb' => '', 'depth' =>'1' ) ); ?>
		<p class="creditos textright col-4">
		    <?php if (is_user_logged_in()): ?>
                <a class="login" href="<?php echo admin_url(); ?>">Administração</a> &bull;
            <?php else: ?>
                <a class="login" href="<?php echo wp_login_url(); ?>">Login</a> &bull;
            <?php endif; ?>
    	    <a href="http://campanhacompleta.com.br" title="Campanha Completa"><img src="<?php bloginfo( 'template_url' ); ?>/img/campanha-completa.png" alt="" /></a> &bull; 
		    <a href="http://wordpress.org"><img src="<?php bloginfo( 'template_url' ); ?>/img/wp.png" alt="" /></a>
		</p>
	</footer>
	<!-- #main-footer -->
<?php wp_footer(); ?>
</body>
</html>
