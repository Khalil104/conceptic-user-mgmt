<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h2>Modifier <?php echo e(ucfirst($field)); ?></h2>

        <form action="<?php echo e(route('update.process', [$user->id, $field])); ?>", method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="<?php echo e($field); ?>" class="form-label"><?php echo e(ucfirst($field)); ?></label>
                    <input type="text"  name="<?php echo e($field); ?>" id="<?php echo e($field); ?>" value="<?php echo e($user->$field); ?>" class="form-control">
                </div>

                <button class="btn btn-primary">
                    Enregistrer
                </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/auth/update.blade.php ENDPATH**/ ?>