<?php
if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

// $GETSOCIAL_URL = 'http://getsocial.io';
// $GETSOCIAL_URL = 'http://localhost:3000';

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$GS = new GS(   get_option('gs-api-key'),
                get_option('gs-identifier'),
                get_option('gs-lang'));

$site_info = $GS->refreshSite();

wp_register_style( 'getsocial-style', plugins_url('../css/getsocial-style.css', __FILE__) );

wp_enqueue_style( 'getsocial-style' );

wp_register_script( 'plugin', plugins_url('../js/plugin.js', __FILE__) );

wp_enqueue_script( 'plugin' );

?>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<header class="gs-clearfix">
    <div class="wrap-header">
        <h1>
            <img src="<?php echo plugins_url( '../images/logo.png', __FILE__ ) ?>" alt="GetSocial" />
            <?php if(isset($sub_menu)): ?>
                <small>- <?php echo $sub_menu ?></small>
            <?php endif; ?>
        </h1>

        <h2>
            We provide trackable social sharing buttons that identify which visitors are sharing your content. <br/>
            We also help you understand how social sharing is contributing to your traffic and conversions.
        </h2>
    </div>

</header>

<?php if(get_option('gs-api-key') != ''): ?>
<div class="cl"></div>
<div class="top-nav">
    <div class="wrap">
        <a href="admin.php?page=<?php echo slug_path('init.php') ?>" class="<?php echo !isset($_GET['tab']) ? 'active' : '' ?>"><i class="fa fa-home"></i>Home</a>
        <a href="admin.php?page=<?php echo slug_path('init.php&tab=settings') ?>" class="<?php echo ($_GET['tab'] == 'settings') ? 'active' : '' ?>"><i class="fa fa-cog"></i>Settings</a>
        <a href="mailto:support@getsocial.io?subject=GetSocial.io Wordpress Plugin Support"><i class="fa fa-question-circle"></i>Can we help you?</a>
    </div>
</div>
<?php endif; ?>



<script type="text/javascript">
    function toggle(id) {
        var e = document.getElementById(id);

        e.style.display = (e.style.display == 'block' ? 'none' : 'block');
    }
</script>
