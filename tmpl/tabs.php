<h2 class="nav-tab-wrapper">
    <a href="admin.php?page=<? echo slug_path('init.php') ?>" class="nav-tab <?php echo !isset($_GET['tab']) ? 'nav-tab-active' : '' ?>">GetSocial Settings</a>
    <a href="admin.php?page=<? echo slug_path('init.php&tab=groups') ?>" class="nav-tab <?php echo $_GET['tab'] == 'groups' ? 'nav-tab-active' : '' ?>">Sharing Bar</a>
    <a href="admin.php?page=<? echo slug_path('init.php&tab=custom-expressions') ?>" class="nav-tab <?php echo $_GET['tab'] == 'custom-expressions' ? 'nav-tab-active' : '' ?>">Custom Actions</a>
    <a href="mailto:support@getsocial.io" class="nav-tab help">Can we help you?</a>
</h2>
