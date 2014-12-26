<h2><i class="fa fa-list"></i>Apps</h2>
<div class="app-list">
    <?php
        $apps = array(
            'social bar' => array(
                'file' => 'social-bar',
                'active' => (get_option('gs-group-active') == '1'),
            ),
            'floating bar' => array(
                'file' => 'floating-bar',
                'active' => (get_option('gs-floating-active') == '1'),
            ),
            // 'native bar' => array(
            //     'file' => 'native-bar'
            // ),
            'custom expressions' => array(
                'file' => 'custom-expressions',
                'active' => (get_option('gs-custom-expression-active') == '1'),
            ),
            // 'url tracking' => array(
            //     'file' => 'url tracking'
            // ),
            // 'conversions'=> array(
            //     'file' => 'conversions'
            // )
        );

        foreach($apps as $app => $settings):
    ?>

    <div class="app-wrapper">
        <div class="app-link">
            <? if($settings['active']): ?>
                <div class="app-status done"><i class="fa fa-check"></i></div>
            <? endif; ?>
            <img src="<? echo plugins_url( '../images/'.$settings['file'].'.png', __FILE__ ) ?>" alt="">
            <div class="app-link-buttons app-type-edit">
                <a href="admin.php?page=<? echo slug_path('init.php&tab='.$settings['file']) ?>">

                    <?php echo ($settings['active']) ? '<i class="fa fa-edit"></i>Edit' : '<i class="fa fa-plus"></i>Add' ?>
                </a>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
</div>
