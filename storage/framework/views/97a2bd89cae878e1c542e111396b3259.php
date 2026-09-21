

<?php $__env->startSection('title', 'Notifications - Conceptic'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-bell me-2"></i>Mes Notifications
        </h2>
        
        <?php if(isset($user) && $user->unreadNotifications()->count() > 0): ?>
            <form action="<?php echo e(route('notifications.mark-all-read')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-all"></i> Tout marquer comme lu
                </button>
            </form>
        <?php endif; ?>
    </div>

    <?php if($notifications->isEmpty()): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox display-4 d-block mb-3"></i>
            <h5>Aucune notification pour le moment</h5>
            <p class="mb-0">Vous serez notifié lors des changements importants sur votre compte.</p>
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="list-group-item list-group-item-action <?php echo e($notification->read_at ? 'opacity-75' : 'border-start border-4 border-primary'); ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">
                                <?php echo e($notification->data['title'] ?? 'Notification'); ?>

                            </h6>
                            <p class="mb-1 text-muted">
                                <?php echo e($notification->data['message']); ?>

                            </p>
                        </div>
                        
                        <?php if(!$notification->read_at): ?>
                            <form action="<?php echo e(route('notifications.read', $notification->id)); ?>" method="POST" class="ms-3">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    Marquer lu
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <small class="text-muted">
                        <?php echo e($notification->created_at->diffForHumans()); ?>

                    </small>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Master IFRI 2024\Stage\conceptic_user_mgmt\resources\views/dashboard/notifications/index.blade.php ENDPATH**/ ?>