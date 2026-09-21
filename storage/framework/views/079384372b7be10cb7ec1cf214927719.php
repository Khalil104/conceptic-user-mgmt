<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Paramètres du compte</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e($errors->first()); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Nom et Prénom(s)</h5>
                    <p><?php echo e($user->name); ?></p>
                    <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'name'])); ?>" class="btn btn-outline-primary">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Adresse mail</h5>
                    <p><?php echo e($user->email); ?></p>
                    <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'email'])); ?>" class="btn btn-outline-primary">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Statut</h5>
                    <p><?php echo e($user->status); ?></p>
                    <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'status'])); ?>" class="btn btn-outline-primary">
                        Modifier
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Mot de passe</h5>
                    <p>********</p>
                    <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'password'])); ?>" class="btn btn-outline-primary">
                        Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="text-center mt-4">
        <p class="text-muted">© 2026 Conceptic.io. Tous droits réservés.</p>
    </footer>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/settings.blade.php ENDPATH**/ ?>