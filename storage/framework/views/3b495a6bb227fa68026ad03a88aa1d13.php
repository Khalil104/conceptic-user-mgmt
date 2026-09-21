<?php $__env->startSection('title', 'Accueil'); ?>

<?php $__env->startSection('header'); ?>
    <hr>
    <h1 class="lead text-center">Bienvenue chez <a href="https://conceptic.io"><strong>CONCEPTIC.IO</strong></a></h1>
    <hr>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center gap-3 mt-5">
    <a href="<?php echo e(route('login.show')); ?>" class="btn btn-primary">Se connecter</a>
    <a href="<?php echo e(route('register.show')); ?>" class="btn btn-success">S'inscrire</a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    &copy; 2026 conceptic.io. Tous droits réservés.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Master IFRI 2024\Stage\conceptic_user_mgmt\resources\views/index.blade.php ENDPATH**/ ?>