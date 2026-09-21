<?php $__env->startSection('title', 'Me | Conceptic User Mgmt'); ?>

<?php if(session('succès')): ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?php echo e(session('succès')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
<?php endif; ?>

<?php $__env->startSection('content'); ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bienvenue chez Conceptic.io, <b><?php echo e($user->name); ?></b></h2>
            <div class="dropdown">
                <img src="images/default_avatar.jpeg" alt="Profil" class="rounded-circle" width="50" height="50">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Menu
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="<?php echo e(route('about')); ?>" class="dropdown-item">À propos</a></li>
                    <li><a href="#" class="dropdown-item">Paramètres</a></li>
                    <li>
                        <a href="#"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            class="dropdown-item text-danger">
                            Se déconnecter
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="post" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Nom et Prénom(s)</h5>
                        <p><?php echo e($user->name); ?></p>
                        <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'name'])); ?>">
                            <button class="btn btn-outline-primary">Modifier</button>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Adresse mail</h5>
                        <p><?php echo e($user->email); ?></p>
                         <a href="<?php echo e(route('update.show', ['user' =>$user->id, 'field' => 'email'])); ?>">
                            <button class="btn btn-outline-primary">Modifier</button>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Rôle</h5>
                        <p> <?php echo e($user->role); ?></p>
                        <small class="text-muted">Non modifiable</small>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Statut</h5>
                        <p><?php echo e($user->status); ?></p>
                         <a href="<?php echo e(route('update.show', ['user' => $user->id, 'field' => 'status'])); ?>">
                            <button class="btn btn-outline-primary ">Modifier</button>
                        </a>
                    </div>
                    
                    <?php
                        $colors = [
                            'active' => 'bg-success',
                            'inactive' => 'bg-primary',
                            'suspended' => 'bg-warning',
                            'deleted' => 'bg-danger'
                        ];
                    ?>

                    <span class=" mt-4 badge rounded-pill <?php echo e($colors[$user->status] ?? 'bg-secondary'); ?>">&nbsp;</span>

                </div>
            </div>
        </div>
    </div>

    
    <div class="mt-4">
        <form method="post" action="<?php echo e(route('delete.process', ['id' => $user->id])); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Voulez-vous supprimer votre compte ? Cette action est irréversible.')">
                Supprimer mon compte
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    &copy; 2026 conceptic.io. Tout droits réservés
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/me.blade.php ENDPATH**/ ?>