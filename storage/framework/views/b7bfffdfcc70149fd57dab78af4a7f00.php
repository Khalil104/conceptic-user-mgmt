<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="m-4 text-center">Bienvenue chez Conceptic.io, <span class="text-primary"><?php echo e($user->name); ?></span></h2>
    <div class="dropdown">
        <img src="images/default_avatar.jpeg" alt="Profil" class="rounded-circle border" width="50" height="50">
        <button class="btn btn-outline-secondary dropdown-toggle ms-2" type="button" data-bs-toggle="dropdown">
            Menu
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a href="<?php echo e(route('about')); ?>" class="dropdown-item">À propos</a></li>
            <li><a href="#" class="dropdown-item">Paramètres</a></li>
            <li>
                <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Se déconnecter
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
        </ul>
    </div>
</div>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <h2 class="mb-4">Tableau de bord</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Utilisateurs actifs</h5>
                        <h2 class="fw-bold"><?php echo e($stats['users']['active']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">Utilisateurs supprimés</h5>
                        <h2 class="fw-bold"><?php echo e($stats['users']['deleted']); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Total historique</h5>
                        <h2 class="fw-bold"><?php echo e($stats['users']['total_historical']); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="alert alert-info">
                <strong>Créés aujourd'hui :</strong> <?php echo e($stats['activity']['created_today']); ?> <br>
                <strong>Modifiés aujourd'hui :</strong> <?php echo e($stats['activity']['updated_at']); ?> <br>
                <strong>Taux de rétention :</strong> <?php echo e($stats['ratios']['retention_rate']); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('list'); ?>
<div class="container-fluid mt-5">
    <h2 class="mb-4">Liste des utilisateurs</h2>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->role); ?></td>
                    <td>
                        <span class="badge <?php echo e($user->status === 'active' ? 'bg-success' : 'bg-secondary'); ?>">
                            <?php echo e($user->status); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <!-- Option 1: Boutons visibles -->
                        <a href="<?php echo e(route('update.process', ['user' => $user->id, 'field' => 'name'])); ?>" class="btn btn-sm btn-outline-primary me-1">Changer nom</a>
                        <a href="<?php echo e(route('update.process', ['user' => $user->id, 'field' => 'status'])); ?>" class="btn btn-sm btn-outline-warning me-1">Changer status</a>

                        <form action="<?php echo e(route('delete.process', ['id' => $user->id])); ?>" method="post" class="d-inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/dashboard.blade.php ENDPATH**/ ?>