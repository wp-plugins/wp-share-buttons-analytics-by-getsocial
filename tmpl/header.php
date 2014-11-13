<?php
if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$GETSOCIAL_URL = 'http://getsocial.io';

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$GS = new GS(   get_option('gs-api-key'),
                get_option('gs-identifier'),
                get_option('gs-elements'),
                get_option('gs-lang'));

if(isset($_GET["refresh"]) && $GS->needs_update()):
    $site_info = $GS->refreshSite();
endif;

$needs_update = $GS->needs_update();

wp_register_style( 'getsocial-style', plugins_url('../css/getsocial-style.css', __FILE__) );
wp_register_style( 'group-buttons', plugins_url('../css/group-buttons.css', __FILE__) );
wp_register_style( 'jquery.onoff', plugins_url('../css/jquery.onoff.css', __FILE__) );

wp_enqueue_style( 'getsocial-style' );
wp_enqueue_style( 'group-buttons' );
wp_enqueue_style( 'jquery.onoff' );

wp_register_script( 'builder', plugins_url('../js/builder.js', __FILE__) );
wp_register_script( 'jquery.onoff.min', plugins_url('../js/jquery.onoff.min.js', __FILE__) );
wp_register_script( 'plugin', plugins_url('../js/plugin.js', __FILE__) );

wp_enqueue_script( 'builder' );
wp_enqueue_script( 'jquery.onoff.min' );
wp_enqueue_script( 'plugin' );

?>

<header class="gs-clearfix">
    <h1>
        <img src="<?= plugins_url( '../images/logo.png', __FILE__ ) ?>" alt="GetSocial" />
        <? if(isset($sub_menu)): ?>
            <small>- <?= $sub_menu ?></small>
        <? endif; ?>
    </h1>

    <h2>
        We provide trackable social sharing buttons that identify which visitors are sharing your content. <br/>
        We also help you understand how social sharing is contributing to your traffic and conversions.
    </h2>
</header>

<script type="text/javascript">
    function toggle(id) {
        var e = document.getElementById(id);

        e.style.display = (e.style.display == 'block' ? 'none' : 'block');
    }
</script>
