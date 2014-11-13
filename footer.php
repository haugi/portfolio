<?php
/*
Template: Portfolio
Author: Markus Haug

Version: 1.0

*/
?>
<?php
$options = get_option('kb_theme_options');
?>
			<div class="seperator"></div>
			<div class="footer">
				<div class="social">
					<?php getSocialIcons() ?>
				</div>
				<div class="footer-nav">
					<?php get_Menu('footer-menu', 'Footer Menu'); ?> 
					<?php getCopyright() ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="overlay">
			<div id="overlay-content"></div>
		</div>
		
		<?php ga_code() ?>
		<?php wp_footer(); ?>
	</body>
</html>