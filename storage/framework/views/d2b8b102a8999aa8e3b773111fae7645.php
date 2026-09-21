<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Confirmer la restauration</h2>

    
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-3">
               Entrez le mot de passe reçu par mail
                Cette action réactivera votre profil désactivé.
            </p>

            <form method="POST" action="<?php echo e(route('confirm-restore.process')); ?>">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="email" value="<?php echo e(session('restore_email')); ?>">

                
                <div class="mb-3">
                    <label for="code" class="form-label">Code de restauration</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Entrez le code reçu par email">
                </div>

                <button type="submit" class="btn btn-primary">Confirmer la restauration</button>
            </form>
        </div>
    </div>

    
    <?php $__env->startSection('footer'); ?>
        © 2026 Conceptic.io. Tous droits réservés.
    <?php $__env->stopSection(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/confirm-restore.blade.php ENDPATH**/ ?>