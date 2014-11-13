<?php if($needs_update == '2'): ?>
    <div class="notification-bar red-cta">
        <p>Having some problems getting an answer from Getsocial... Could you try later?</p>
    </div>
<?php elseif($needs_update == '1'): ?>
    <div class="notification-bar green-cta">
        <p>Changes have been made to your custom action buttons. Please update your changes here!</p>
        <a href="<?= $actual_link ?>&refresh=1">Update now!</a>
    </div>
<?php endif; ?>
