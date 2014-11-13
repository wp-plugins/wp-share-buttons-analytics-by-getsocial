<? include('tmpl/header.php'); ?>
<? include('tmpl/alerts.php'); ?>

<div class="wrap">
    <?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == true): ?>
        <div id="message" class="updated below-h2">
            <p>Preferences updated with success</p>
        </div>
    <?php endif; ?>


    <?php if(get_option('gs-api-key') == ''): ?>

    <table id="steps">
        <thead>
            <tr valign="top">
                <th>
                <h1>Step 1 - Create a GetSocial account</h1>
                <p>To get started, register your GetSocial account and <strong>find your API key in the site settings. If you already have an account, log in.</strong></p>
                </th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
        <tfoot>
            <tr valign="top">
                <td>
                    <a href="<?php echo $GETSOCIAL_URL ?>?source=wordpress" target="_blank" class="button button-primary">Create GetSocial account</a> ___ 
                    <a href="<?php echo $GETSOCIAL_URL ?>?source=wordpress" target="_blank" class="button button-primary">Login in your account</a></p>
                </td>
            </tr>
            <tr valign="top" align="left">
                <th>
                <h1>Step 2 - Insert your API Key</h1>
                <p>Visit your <a href="http://www.getsocial.io/redirect/profile">GetSocial profile settings</a> , find, copy and paste your API key in the form below.</p>
                </th>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>

        <?php include 'tmpl/tabs.php' ?>

    <?php endif; ?>

    <?php if( !isset($_GET['tab']) ): ?>

        <?php include('tmpl/settings.php') ?>

    <?php else: ?>

        <?php include('tmpl/'.$_GET['tab'].'.php') ?>

    <?php endif; ?>
</div>
