<?php 
function MonaAdmin() {
    return (new MonaAdmin());
}

function get_admin_menu_tabs(){
    return MonaAdmin()->register_admin_pages();
}

add_filter( 'admin_body_class', 'mona_filter_admin_classes' );
function mona_filter_admin_classes( $classes ) {
	$currentScreen = get_current_screen();
    if ( isset( $currentScreen->base ) && $currentScreen->base === 'appearance_page_mona-filter-admin' ) { 
        $classes .= ' mona-filter-admin';
    }
	return $classes;
}

add_action( 'admin_footer', 'mona_filter_admin_footer' );
function mona_filter_admin_footer() {
    echo '<div id="mona-toast"></div>';
    $hideAll = (new MonaSettingOverview())->__field_value( 'notice_hide_all', true );
    if ( $hideAll ) {
        echo '<style>.update-plugins, .update-nag, .updated, .error, .is-dismissible, .notice, #wpfooter, .welcome-panel { display: none!important; }</style>';
    }
}

//add_action( 'init', 'mona_remove_core_updates' );
function mona_remove_core_updates() {
    $disUpdate = (new MonaSettingOverview())->__field_value( 'disabled_update', true );
    if ( $disUpdate ) { 
        add_filter( 'pre_site_transient_update_core', '__return_null' );
        add_filter( 'pre_site_transient_update_plugins', '__return_null' );
        add_filter( 'pre_site_transient_update_themes', '__return_null' );
    } 
}

add_action( 'wp_dashboard_setup', 'mona_dashboard_remove_metaboxes' );
function mona_dashboard_remove_metaboxes(){
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); 
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); 
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); 
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' ); 
    remove_meta_box( 'wpdm_dashboard_widget', 'dashboard', 'normal' ); 
    remove_meta_box( 'dashboard_custom_feed', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); 
    remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' ); 
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); 
}

add_action( 'admin_bar_menu', 'mona_change_wp_admin_bar_logo', 999 );
function mona_change_wp_admin_bar_logo( $wp_admin_bar ) {
    $args = [
        'id'    => 'wp-logo',
        'title' => '',
        'title' => '<img src="' . get_site_icon_url() . '" alt="">',
        'href'  => home_url() . '/wp-admin/index.php',
    ];
    $wp_admin_bar->add_node( $args );
}


function getLogoCustomHtml() {
    $custom_logo_id     = get_theme_mod( 'custom_logo' );
    $custom_logo_url    = wp_get_attachment_image_url($custom_logo_id, 'full');
    $site_title         = get_bloginfo( 'name' );
    $user_id            = get_current_user_id(); // Replace with the user ID you want to get the profile URL for
    $user_profile_url   = admin_url( 'profile.php' );
    ob_start(); 
    ?>
    <div class="overview-profile">
        <?php if ( ! empty ( $custom_logo_url ) ) { ?>
        <div class="overview-profile-logo">
            <img src="<?php echo $custom_logo_url; ?>" alt="logo" />
        </div>
        <?php } ?>
        <?php if ( ! empty( $site_title ) ) { ?>
        <div class="overview-profile-title">
            <?php echo $site_title; ?>
        </div>
        <?php } ?>
        <div class="overview-profile-action">
            <div class="overview-profile-user">
                <span class="monaRedirectAdmin" data-redirect="<?php echo $user_profile_url; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/core/admin/assets/images/ic-admin-user.svg" />
                </span>
            </div>
            <div class="overview-profile-logout">
                <span class="monaRedirectAdmin" data-redirect="<?php echo wp_logout_url( home_url() . '/wp-login.php' ); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/core/admin/assets/images/ic-admin-logout.svg" />
                </span>
            </div>
        </div>
    </div>
    <?php 
    return ob_get_clean();
}

add_action( 'admin_menu', 'mona_add_html_at_top_of_first_menu_item' );
function mona_add_html_at_top_of_first_menu_item() {
    global $menu;
    $html          = getLogoCustomHtml();
    $new_menu_item = array( $html , 'read', 'javascript:;', '', 'wp-menu-overview-profile' ); 
    array_unshift( $menu, $new_menu_item );
}

add_filter(
    'admin_footer_text',
    function ( $footer_text ) {
        $footer_text = 'Powered by <a href="https://mona.media/" target="_blank" rel="noopener">MONA.Media / Website</a>';
        return $footer_text;
    }
);