<?php


global $WOOCS;
//echo $WOOCS->convert_from_to_currency(28, 'EUR', 'GBP');
$custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
?>
<!-- [ <?php echo str_replace( $_SERVER['DOCUMENT_ROOT'], '', __FILE__ ); ?> -->
<!--</div>-->
<!--</div>-->
</div>
<?php
// --------- OLD CODE, MUST BU DELETE---------
//if ( !is_front_page() ) {
if ( 1 > 2 ) {
	?>


  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalTitle">Register</h5>
        </div>
        <div class="modal-body">
          <form name="loginform" id="loginform" action="" method="post">
            <p>
              <input type="text" name="log" id="user_login_reg" class="input" value="" size="20" autocapitalize="off"
                     placeholder="Login">
            </p>

            <p>
              <input type="email" name="email" id="user_email_reg" class="input" value="" size="20" autocapitalize="off"
                     placeholder="E-Mail">
            </p>

            <div class="user-pass-wrap">

              <div class="wp-pwd">
                <input type="password" name="pwd" id="user_pass_reg" class="input password-input" value="" size="20"
                       autocomplete="current-password" placeholder="Password">

              </div>
              <div class="wp-pwd">
                <input type="password" name="pwd2" id="user_pass_confirm_reg" class="input password-input" value=""
                       size="20" placeholder="Confirm Password" autocomplete="current-password">

              </div>

            </div>

            <p class="accept_terms">
              <input type="checkbox" id="agree_reg" value="forever">
              <label for="agree">
                I accept <a href="<?php echo get_permalink( 3 ); ?>">Privacy Policy</a> and <a
                  href="<?php echo get_permalink( 3 ); ?>">Terms of Service</a>
              </label>
            </p>

            <div class="register_error"></div>
            <div class="register_success"></div>

            <input type="submit" value="submit">
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" class="forgot">
            Forgot password?
          </a>

          <p>
            Already have an account?
          </p>
          <a href="#" data-toggle="modal" data-target="#loginModal" data-dismiss="modal" aria-label="Close"
             class="reg_link">Log In</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalTitle">Login</h5>
        </div>
        <div class="modal-body">
          <form action="<?php echo wp_login_url(); ?>" method="post">
            <p>
              <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="off"
                     placeholder="Email" autocomplete="username">
            </p>

            <div class="user-pass-wrap">
              <div class="wp-pwd">
                <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20"
                       autocomplete="current-password" placeholder="Password">

              </div>
            </div>

            <p class="submit">
              <input type="submit" name="wp-submit" id="wp-submit" value="Log In">
            </p>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#" class="forgot">
            Forgot password?
          </a>

          <p>
            Don’t have an account?
          </p>
          <a href="#" data-toggle="modal" data-target="#registerModal" class="reg_link" data-dismiss="modal"
             aria-label="Close">Register here</a>
        </div>
      </div>
    </div>
  </div>

	<?php if ( ! if_is_blog() ) { ?>
    <!-- default footer -->
    <footer class="footer ">
      <div class="container__header">
        <div class="footer__inner">

					<?php if ( isset( $custom_logo__url[0] ) ) { ?>
            <a href="<?php echo home_url(); ?>" class="footer__logo">
              <img src="<?php echo $custom_logo__url[0]; ?>" alt="alt"></a>
					<?php } ?>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_menu',
						'container'      => false,
						'menu_id'        => false,
						'menu_class'     => 'footer__nav',
						'depth'          => 1,
					) );
					?>

					<?php
					$social_media = get_field( 'social_media', 'footer' );
					if ( $social_media ) {
						?>
            <ul class="footer__social"><?php
						foreach ( $social_media as $link ) {
							?>
              <li><a href="<?php echo $link['url'] ?>"><a href="#"><img src="<?php echo $link['icon']['url'] ?>"
                                                                        alt="<?php echo $link['icon']['alt'] ?>"></a>
              </li><?php
						}
						?></ul><?php
					}
					?>

          <div class="b-copyright">©<?php echo date( 'Y' ) ?> <?php the_field( 'copiright', 'footer' ); ?>

            Developed by <a href="https://webcapitan.com" rel="nofollow">WEBCAPITAN TEAM</a>
          </div>

          <div class="b-accept__payments">
						<?php
						$payments = get_field( 'payment_images', 'footer' );
						if ( $payments ) {
							foreach ( $payments as $image ) {
								?><img src="<?php echo $image['image']['url'] ?>" alt="<?php echo $image['image']['alt'] ?>"><?php
							}
						}
						?>
          </div>
          <div class="d-development">
            Developed by <a href="https://webcapitan.com" rel="nofollow">WEBCAPITAN TEAM</a>
          </div>
        </div>

      </div>

    </footer>
    <!-- /default footer -->
	<?php } else { ?>
    <!-- blog footer -->
		<?php
		// if ( is_singular('news')){
		?>
    <footer class="footer">
      <div class="container__header">
        <div class="footer__inner">

					<?php if ( isset( $custom_logo__url[0] ) ) { ?>
            <a href="<?php echo home_url(); ?>" class="footer__logo"><img src="<?php echo $custom_logo__url[0]; ?>"
                                                                          alt="alt"></a>
					<?php } ?>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_menu',
						'container'      => false,
						'menu_id'        => false,
						'menu_class'     => 'footer__nav',
						'depth'          => 1,
					) );
					?>

					<?php
					$social_media = get_field( 'social_media', 'footer' );
					if ( $social_media ) {
						?>
            <ul class="footer__social"><?php
						foreach ( $social_media as $link ) {
							var_dump( $link );
							?>
              <li><a href="<?php echo $link['url'] ?>"><i class="fab <?php echo $link['icon'] ?>"></i></a></li><?php
						}
						?></ul><?php
					}
					?>

          <div class="b-copyright">©<?php echo date( 'Y' ) ?> <?php the_field( 'copiright', 'footer' ); ?></div>

          <div class="b-accept__payments">
						<?php
						$payments = get_field( 'payment_images', 'footer' );
						if ( $payments ) {
							foreach ( $payments as $image ) {
								?><img src="<?php echo $image['image']['url'] ?>" alt="<?php echo $image['image']['alt'] ?>"><?php
							}
						}
						?>
          </div>
          <div class="d-development">
            Developed by <a href="https://webcapitan.com" rel="nofollow">WEBCAPITAN TEAM</a>
          </div>
        </div>
      </div>
    </footer>
		<?php
		// }
		?>
    <!-- /blog footer -->
	<?php } ?>
<?php } /* --------- /OLD CODE, MUST BU DELETE---------*/ else { ?>

  <footer class="footer">
    <div class="container-fluid">
      <div class="footer__all-content">

        <a href="<?php echo home_url(); ?>" class="footer__logo-wrapper">
          <img src="<?php echo $custom_logo__url[0]; ?>" alt="alt">
        </a>

				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'container'      => false,
					'menu_id'        => false,
					'menu_class'     => 'footer__menu',
					'depth'          => 1,
				) );
				?>

				<?php
				$social_media = get_field( 'social_media', 'footer' );
				if ( $social_media ) {
					?>
          <ul class="footer__soc-links">
						<?php
						foreach ( $social_media as $link ) {
							?>
              <li><a href="<?php echo $link['url'] ?>"><img src="<?php echo $link['icon']['url'] ?>"
                                                            alt="<?php echo $link['icon']['alt'] ?>"></a></li><?php
						}
						?>
          </ul>
					<?php
				}
				?>

        <div class="empty"></div>
        <div class="footer__games">
          <h5>
            Games
          </h5>

          <ul>

              <?php
                $repeater= get_field('footer_game_list', 'options');

                if ( is_array($repeater) && count($repeater) )
                {
                   foreach ($repeater as $key1 => $item1)
                   {
                      $term = get_term($item1['game']);
                      //$link = get_term_link();
                      //$gp = get_post($item1['game']);

                       $term_name = $term->name;
                       $term_link = get_term_link($term);

                      echo "<li><a href=\"$term_link\">$term_name</a></li>\n";
                   }
                }
              ?>



	          <?php
	          /*$game_design = Game_Change::get_instance()->get_game_design();
	          $tabs = $game_design['tabs'];
	          if (isset($tabs) && is_array($tabs) && count($tabs))
	          {
		          foreach ($tabs as $key => $item)
		          {
			          $link = get_term_link($item['category']);

			          echo "
<li>
<a href=\"$link\">$item[title]</a>
</li>";
		          }
	          }*/

	          ?>

          </ul>
        </div>
        <div class="footer__payments">
					<?php
					$payments = get_field( 'payment_images', 'footer' );
					if ( $payments ) {
						foreach ( $payments as $image ) {
							?><img src="<?php echo $image['image']['url'] ?>" alt="<?php echo $image['image']['alt'] ?>"><?php
						}
					}
					?>
        </div>
        <div class="footer__coopyright">
          <p>©<span class="year"></span> <?php the_field( 'copiright', 'footer' ); ?> </p>
        </div>
        <a href="#" class="btn btn_show_more btn-border not_showed">Show More</a>
        <div class="footer__coopyright footer__coopyright_dev">
          <p>Developed by <a target="_blank" href="https://webcapitan.com/">WEBCAPITAN TEAM</a></p>
        </div>

      </div>
    </div>

    <!--<div id="smartsupp-widget-button" class="chat-block">
				<div class="chat__wrapper" role="button" tabindex="0" data-testid="widgetButton">
						<div data-testid="widgetButtontext">Chat</div>
						<div class="chat__image">
								<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M17.1823 7.15953C17.1823 4.28659 17.1823 2.85012 16.4928 1.81823C16.1943 1.37152 15.8108 0.98797 15.364 0.689485C14.3322 0 12.8957 0 10.0227 0H7.97716C5.10422 0 3.66775 0 2.63586 0.689485C2.18915 0.98797 1.8056 1.37152 1.50711 1.81823C0.817627 2.85012 0.817627 4.28659 0.817627 7.15953C0.817627 10.0325 0.817627 11.4689 1.50711 12.5008C1.8056 12.9475 2.18915 13.3311 2.63586 13.6296C3.5373 14.2319 4.74749 14.308 6.95437 14.3177V14.3191L8.08514 16.5806C8.46206 17.3345 9.53784 17.3345 9.91476 16.5806L11.0455 14.3191V14.3177C13.2524 14.308 14.4626 14.2319 15.364 13.6296C15.8108 13.3311 16.1943 12.9475 16.4928 12.5008C17.1823 11.4689 17.1823 10.0325 17.1823 7.15953ZM5.93175 4.1139C5.37947 4.1139 4.93175 4.56162 4.93175 5.1139C4.93175 5.66619 5.37947 6.1139 5.93175 6.1139H12.0685C12.6208 6.1139 13.0685 5.66619 13.0685 5.1139C13.0685 4.56162 12.6208 4.1139 12.0685 4.1139H5.93175ZM5.93175 8.20506C5.37947 8.20506 4.93175 8.65278 4.93175 9.20506C4.93175 9.75735 5.37947 10.2051 5.93175 10.2051H9.00012C9.55241 10.2051 10.0001 9.75735 10.0001 9.20506C10.0001 8.65278 9.55241 8.20506 9.00012 8.20506H5.93175Z" fill="white"/>
								</svg>
						</div>
				</div>
				<div id="widget-unread-messages-badge" class="chat__messages-number" data-testid="widgetUnreadMessagesBadge">1</div>

		</div>-->

    <!-- Login modal -->
    <div class="modal fade myAccountModal" id="signInModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
          <div class="modal__body form-modal__body">
            <div class="modal__wrapper">
              <div class="modal__form">
                <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-form__wrapper">
                  <h3>Sign in</h3>
                  <ul class="login__list">
                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=discord" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="discord" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/discord.svg" alt="icon">
                        <h5>Discord</h5>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=google" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/google.svg" alt="icon"><h5>Google</h5>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=steam" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="steam" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/steam.svg" alt="icon">
                        <h5>Steam</h5>
                      </a>
                    </li>
                  </ul>
                  <h4 class="title__sign-email">or sign up with email</h4>

                  <form action="<?php echo wp_login_url(); ?>" method="post" class="registration__form">
                    <div class="form-registration__input-wrapper">
                      <div class="form__input input__full-width form-username">
                        <input type="text" name="log" id="user_login" autocapitalize="off" value=""
                               placeholder="Username">
                      </div>
                      <div class="form__input input__full-width form-password">
                        <div class="password-input">
                          <input type="password" class="input__password" name="pwd" id="user_pass"
                                 placeholder="Password" autocomplete="current-password">
                          <span class="show-password-input"></span>
                        </div>
                      </div>
                    </div>

                    <div class="form__button">
                      <button type="submit" class="btn-main">Sign in</button>
                    </div>
                  </form>
                  <span>Not registered yet?<div class="link-modal" data-toggle="modal" data-target="#signUpModal"
                                                data-dismiss="modal">Sign Up</div>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Login modal -->

    <!-- Register modal -->
    <div class="modal fade myAccountModal" id="signUpModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
          <div class="modal__body form-modal__body">
            <div class="modal__wrapper">
              <div class="modal__form">
                <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-form__wrapper">
                  <h3>Create account</h3>
                  <ul class="login__list">
                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=discord" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="discord" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/discord.svg" alt="icon">
                        <h5>Discord</h5>
                      </a>
                    </li>

                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=google" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/google.svg" alt="icon"><h5>Google</h5>
                      </a>
                    </li>

                    <li>
                      <a href="<?php echo home_url(); ?>/wp-login.php?loginSocial=steam" data-plugin="nsl"
                         data-action="connect" data-redirect="current" data-provider="steam" data-popupwidth="600"
                         data-popupheight="600">
                        <img src="<?php echo theme_url; ?>/img/steam.svg" alt="icon">
                        <h5>Steam</h5>
                      </a>
                    </li>
                  </ul>

                  <h4 class="title__sign-email">or sign up with email</h4>

                  <form name="loginform" id="loginform" action="#" method="post" class="registration__form">
                    <div class="form-registration__input-wrapper">
                      <div class="form__input input__full-width form-username">
                        <input type="text" name="log" id="user_login_reg" value="" placeholder="Username">
                      </div>

                      <div class="form__input input__full-width form-username">
                        <input type="email" name="email" id="user_email_reg" value="" placeholder="E-mail">
                      </div>

                      <div class="form__input input__full-width form-password">
                        <div class="password-input">
                          <input type="password" name="pwd" id="user_pass_reg"
                                 class="input password-input" value="" size="20"
                                 autocomplete="current-password" placeholder="Password">
                          <span class="show-password-input"></span>
                        </div>
                      </div>

                      <div class="form__input input__full-width form-password">
                        <div class="password-input">
                          <input type="password" name="pwd2" id="user_pass_confirm_reg"
                                 class="input password-input" value="" size="20"
                                 placeholder="ConfirmPassword"
                                 autocomplete="current-password">
                          <i class="show-password-input"></i>
                        </div>
                      </div>
                    </div>

                    <p>By clicking Create Account, you agree to our Terms of Service and Privacy Policy</p>

                    <div class="register_error"></div>
                    <div class="register_success"></div>

										<?php
										$google_recaptcha_v2 = get_field( 'google_recaptcha_v2', 'option' );
										$enable_on_sign_ups  = get_field( 'enable_on_sign_ups', 'option' );
										if ( $enable_on_sign_ups ) {
											?>
                      <div class="g-recaptcha" data-sitekey="<?php echo $google_recaptcha_v2; ?>"></div>
										<?php } ?>

                    <div class="form__button">
                      <button type="submit" class="btn-main">Create account</button>
                    </div>
                  </form>

                  <span>Already registered?<div class="link-modal" data-toggle="modal" data-target="#signInModal"
                                                data-dismiss="modal">Sign In</div></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Register modal -->


  </footer>

<?php } ?>


<?php wp_footer(); ?>
<!--  <?php echo str_replace( $_SERVER['DOCUMENT_ROOT'], '', __FILE__ ); ?> ] -->

</body>

</html>