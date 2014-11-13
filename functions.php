<?php
	//require_once ( get_stylesheet_directory() . '/theme-options.php' );
	//define( 'WP_USE_THEMES', false );
	add_theme_support( 'post-thumbnails' );
	add_image_size('home', 600, 9999, true);
	
	
	//Add Menu functions for one menu
	function register_my_menus() {
		register_nav_menus(
			array(
				'header-menu' => __( 'Header Menu' ),
				'footer-menu' => __( 'Footer Menu' )
			)
		);
	}
	add_action( 'init', 'register_my_menus' );
	
	
	the_excerpt_max_charlength(140);
	//Create Excerpt with max length
	function the_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;
	
		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo $excerpt;
		}
	}
	
	//Create Seperator between posts
	function post_seperator($amount, $count) {
		if ($count < $amount) {
			echo '<div class="seperator"></div>';
		}
	}
	
	//Enable widgets for theme
	if ( function_exists('register_sidebar') ) {
		register_sidebar();
	}
	
	function get_Menu($theme_location, $menu) {
		if ( has_nav_menu($theme_location)) {
		    wp_nav_menu(array('theme_location' => $theme_location, 'menu' => $menu));
		}
	}
	
	function getSocialIcons() {
		$options = get_option('kb_theme_options');
		$dir = get_template_directory_uri() . '/img/';
		
		if (isset($options['facebookpage']) && $options['facebookpage'] != "") {
			echo '<a href="' . $options['facebookpage'] . '" target="_blank"><img src="' . $dir . 'facebook.png" alt="Facebook" /></a>';
		}
		
		if (isset($options['twitterpage']) && $options['twitterpage'] != "") {
			echo '<a href="' . $options['twitterpage'] . '" target="_blank"><img src="' . $dir . 'twitter.png" alt="Twitter" /></a>';
		}
		
		if (isset($options['youtubepage']) && $options['youtubepage'] != "") {
			echo '<a href="' . $options['youtubepage'] . '" target="_blank"><img src="' . $dir . 'youtube.png" alt="Youtube" /></a>';
		}
		
		if (isset($options['instagrampage']) && $options['instagrampage'] != "") {
			echo '<a href="' . $options['instagrampage'] . '" target="_blank"><img src="' . $dir . 'instagram.png" alt="Instagram" /></a>';
		}
	}
	
	function getCopyright() {
		$options = get_option('kb_theme_options');
		
		echo $options['copyright'];
	}
	
	/*
	function image_tag($html, $id, $alt, $title) {
		return str_replace('<img ', '<img data-lightbox="image' . $id . '" ', $html);
	}
	add_filter('get_image_tag', 'image_tag', 0, 4);
	*/
	
	function print_comments($comments) {
		
		foreach($comments as $comment) {
			//var_dump($comment);
			$cContent = $comment->comment_content;
			$cAuthor = $comment->comment_author;
			$cDate = get_comment_date('d. F Y - H:i', $comment->comment_ID);
			
			echo '<div class="comment">';
			echo '<span>' . $cAuthor . ' - ' . $cDate  . '</span>';
			echo '<p>' . $cContent . '</p>';
			echo '</div>';
			
		}
	}
	
	function print_comment_form() {
		$commenter = wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$args = array(
			'title_reply' => '',
			'logged_in_as' => '',
			'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . _x( 'Comment', 'noun' ) . '" aria-required="true"></textarea></p>',
			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
					'<p class="comment-form-author">' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="author" name="author" type="text" placeholder="' . __( 'Name', 'domainreference' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' /></p>',

				'email' =>
					'<p class="comment-form-email">' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'<input id="email" name="email" type="text" placeholder="' . __( 'Email', 'domainreference' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"' . $aria_req . ' /></p>'
				)
			)
		);
		comment_form($args);
	}
	
	/*
	function custom_validate_comment_url() {
	    if(empty( $_POST['author'])) // do you url validation here (I am not a regex expert)
	        wp_die( __('Error: please enter a valid url or leave the homepage field empty') );
	}
	
	add_action('pre_comment_on_post', 'custom_validate_comment_url');
	*/
	
	/* ------------------ */
	/* theme options page */
	/* ------------------ */
	
	add_action( 'admin_init', 'theme_options_init' );
	add_action( 'admin_menu', 'theme_options_add_page' );
	
	// Einstellungen registrieren (http://codex.wordpress.org/Function_Reference/register_setting)
	function theme_options_init(){
		register_setting( 'kb_options', 'kb_theme_options', 'kb_validate_options' );
	}
	
	// Seite in der Dashboard-Navigation erstellen
	function theme_options_add_page() {
		add_theme_page('Optionen', 'Optionen', 'edit_theme_options', 'theme-optionen', 'kb_theme_options_page' ); // Seitentitel, Titel in der Navi, Berechtigung zum Editieren (http://codex.wordpress.org/Roles_and_Capabilities) , Slug, Funktion 
	}
	
	// Optionen-Seite erstellen
	function kb_theme_options_page() {
	global $select_options, $radio_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false; ?>
	
	<div class="wrap"> 
	<?php screen_icon(); ?><h2>Theme-Optionen für <?php bloginfo('name'); ?></h2> 
	
	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?> 
	<div class="updated fade">
		<p><strong>Einstellungen gespeichert!</strong></p>
	</div>
	<?php endif; ?>
	
	  <form method="post" action="options.php">
		<?php settings_fields( 'kb_options' ); ?>
	    <?php $options = get_option( 'kb_theme_options' ); ?>
	
	    <table class="form-table">
	      <tr valign="top">
	        <th scope="row">Facebook Page Link</th>
	        <td><input id="kb_theme_options[facebookpage]" class="regular-text" type="text" name="kb_theme_options[facebookpage]" value="<?php esc_attr_e( $options['facebookpage'] ); ?>" /></td>
	      </tr> 
	      <tr valign="top">
	        <th scope="row">Twitter Page Link</th>
	        <td><input id="kb_theme_options[twitterpage]" class="regular-text" type="text" name="kb_theme_options[twitterpage]" value="<?php esc_attr_e( $options['twitterpage'] ); ?>" /></td>
	      </tr>
	      <tr valign="top">
	        <th scope="row">Youtube Page Link</th>
	        <td><input id="kb_theme_options[youtubepage]" class="regular-text" type="text" name="kb_theme_options[youtubepage]" value="<?php esc_attr_e( $options['youtubepage'] ); ?>" /></td>
	      </tr>
	      <tr valign="top">
	        <th scope="row">Instagram Page Link</th>
	        <td><input id="kb_theme_options[instagrampage]" class="regular-text" type="text" name="kb_theme_options[instagrampage]" value="<?php esc_attr_e( $options['instagrampage'] ); ?>" /></td>
	      </tr>
	      <tr valign="top">
	        <th scope="row">Copyright</th>
	        <td><input id="kb_theme_options[copyright]" class="regular-text" type="text" name="kb_theme_options[copyright]" value="<?php esc_attr_e( $options['copyright'] ); ?>" /></td>
	      </tr>  
	      <tr valign="top">
	        <th scope="row">Google Analytics</th>
	        <td><textarea id="kb_theme_options[analytics]" class="large-text" cols="50" rows="10" name="kb_theme_options[analytics]"><?php echo esc_textarea( $options['analytics'] ); ?></textarea></td>
	      </tr>
	    </table>
	    
	    <!-- submit -->
	    <p class="submit"><input type="submit" class="button-primary" value="Einstellungen speichern" /></p>
	  </form>
	</div>
	<?php }
	
	// Strip HTML-Code:
	// Hier kann definiert werden, ob HTML-Code in einem Eingabefeld 
	// automatisch entfernt werden soll. Soll beispielsweise im 
	// Copyright-Feld KEIN HTML-Code erlaubt werden, kommentiert die Zeile 
	// unten wieder ein. http://codex.wordpress.org/Function_Reference/wp_filter_nohtml_kses
	function kb_validate_options( $input ) {
		// $input['copyright'] = wp_filter_nohtml_kses( $input['copyright'] );
		return $input;
	}
	/* Theme Options Page End */
	
	function ga_code() {
		$options = get_option('kb_theme_options');
		$gaCode = $options['analytics'];
		
		if ($gaCode != '') {
			echo $gaCode;
		}
	}
	
?>