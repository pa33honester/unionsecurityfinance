<?php
/** header desktop **/
if ( ! function_exists( 'maxbizz_header_builder' ) ) {
    function maxbizz_header_builder (){
        $header_builder = '';    

        if ( is_page() ) {
            if ( function_exists('rwmb_meta') ) {
                global $wp_query;
                $metabox_fb = rwmb_meta( 'select_header', 'field_type=select_advanced', $wp_query->get_queried_object_id() ); 
                if ($metabox_fb != '') {
                    $header_builder = $metabox_fb;
                }else{
                    $header_builder = maxbizz_get_option('header_layout');
                }
            } 
        }else{
            $header_builder = maxbizz_get_option('header_layout');
        }

        if( !$header_builder ) {
            get_template_part('inc/frontend/header/header-default');
        }else{
            echo '<div class="header-desktop">';
            if ( did_action( 'elementor/loaded' ) ) {               
                echo \Elementor\Plugin::$instance->frontend->get_builder_content( $header_builder ); 
            }
            echo '</div>';
        }
    }
}

/** header mobile **/
if ( ! function_exists( 'maxbizz_mobile_builder' ) ) {
    function maxbizz_mobile_builder (){
        
        if ( is_page() ) {
            if ( function_exists('rwmb_meta') ) {
                global $wp_query;
                $metabox_hmb = rwmb_meta( 'select_header_mobile', 'field_type=select_advanced', $wp_query->get_queried_object_id() ); 
                if ($metabox_hmb != '') {
                    $mobile_builder = $metabox_hmb;
                }else{
                    $mobile_builder = maxbizz_get_option('header_mobile');
                }
            } 
        }else{
            $mobile_builder = maxbizz_get_option('header_mobile');
        }

        if( !$mobile_builder ) {
            get_template_part('inc/frontend/header/header-mobile');
        }else{
            echo '<div class="header-mobile">';
            if ( did_action( 'elementor/loaded' ) ) {               
                echo \Elementor\Plugin::$instance->frontend->get_builder_content( $mobile_builder ); 
            }
            echo '</div>';
        }
    }
}

/** side panel **/
if ( ! function_exists( 'maxbizz_sidepanel_builder' ) ) {
    function maxbizz_sidepanel_builder (){

        $panel_builder = maxbizz_get_option('sidepanel_layout');

        if( !$panel_builder ) {
            return;
        }else{
            if ( did_action( 'elementor/loaded' ) ) {               
                echo \Elementor\Plugin::$instance->frontend->get_builder_content( $panel_builder ); 
            }
        }
    }
}

/** 404 template **/
if ( ! function_exists( 'maxbizz_404_builder' ) ) {
    function maxbizz_404_builder (){

        $error_builder = maxbizz_get_option('page_404');

        if( !$error_builder ) { ?>
            <div class="error-404 not-found text-center">
                <div class="container">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img class="error-logo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-white.svg" alt="404">
                    </a>
                    <h1><?php wp_kses( _e( '404', 'maxbizz' ), wp_kses_allowed_html('post')  ); ?></h1>
                    <h2><?php esc_html_e( 'Sorry! Page Not Found!', 'maxbizz' ); ?></h2>
                    <div class="page-content">
                        <p><?php esc_html_e( 'Oops! The page you are looking for does not exist. Please return to the site’s homepage.', 'maxbizz' ); ?></p>
                        <?php get_search_form(); ?>
                        <a class="octf-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'take me home', 'maxbizz' ); ?></a>
                    </div>
                </div>
            </div>
        <?php }else{
            if ( did_action( 'elementor/loaded' ) ) {               
                echo \Elementor\Plugin::$instance->frontend->get_builder_content( $error_builder ); 
            }
        }
    }
}

/** footer **/
if ( ! function_exists( 'maxbizz_footer_builder' ) ) {
    function maxbizz_footer_builder (){
        $footer_builder = '';    

        if ( is_page() ) {
            if ( function_exists('rwmb_meta') ) {
                global $wp_query;
                $metabox_fb = rwmb_meta( 'select_footer', 'field_type=select_advanced', $wp_query->get_queried_object_id() ); 
                if ($metabox_fb != '') {
                    $footer_builder = $metabox_fb;
                }else{
                    $footer_builder = maxbizz_get_option('footer_layout');
                }
            } 
        }else{
            $footer_builder = maxbizz_get_option('footer_layout');
        }

        if( !$footer_builder ) {
            return;
        }else{
            echo '<footer id="site-footer" class="site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">';
            if ( did_action( 'elementor/loaded' ) ) {               
                echo \Elementor\Plugin::$instance->frontend->get_builder_content( $footer_builder ); 
            }
            echo '</footer>';
        }
    }
}