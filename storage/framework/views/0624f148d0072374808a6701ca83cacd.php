<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h2 class="mb-4">Restaurer mon compte</h2>

        
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-3">
                  Entrez votre adresse mail pour y recevoir le code de vérification.
                </p>

                <form method="POST" action="<?php echo e(route('restore-account.process')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer le code</button>
                </form>
            </div>
        </div>

        <?php $__env->startSection('footer'); ?>
            &copy; 2026 conceptic.io. Tout droits réservés
        <?php $__env->stopSection(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/restore.blade.php ENDPATH**/ ?>