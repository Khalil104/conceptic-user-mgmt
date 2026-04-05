<div class="alert alert-warning">
    Votre compte est désactivé. Voulez-vous le restaurer ?
</div>

<form action="<?php echo e(route('choice')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <button type="submit" name="choice" value="yes" class="btn btn-success">Oui , restaurer</button>
    <button type="submit" name="choice" value="no" class="btn btn-danger">Non, retour à l'accueil</button>
</form><?php /**PATH E:\Master_IFRI\STAGE\Conceptic.io\conceptic_user_mgmt\resources\views/auth/disabled.blade.php ENDPATH**/ ?>