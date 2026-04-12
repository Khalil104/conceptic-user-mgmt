<?php $__env->startSection('title', 'Vérification 2FA | Conceptic User Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 8ovh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Vérification en deux étapes</h4>
            <p class="text-center text-muted">Entrez le code reçu par e-mail</p>
             <?php if($errors->any()): ?>
                 <div class="alert alert-danger">
                    <?php echo e($errors->first()); ?>

                 </div>
             <?php endif; ?>
            <form action="<?php echo e(route('verify-2fa.process')); ?>" method="post">
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="user_id" value="<?php echo e(session('user_id')); ?>">
                
                <div class="mb-3">
                    <label for="code" class="form-label">Code de vérification</label>
                    <input type="text" name="code" id="code"class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('code')); ?>" required autofocus/>
                    <p class="mt-2"><small>Entrez le code à 6 chiffres reçu par mail !</small></p>
                    <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="d-grid">
                    <button type ="submit" class="btn btn-success">Valider</button>
                 </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    &copy; 2026 conceptic.io. Tout droits réservés.
<?php $__env->stopSection(); ?>


<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rhd-khalil/Abdoul-project/conceptic_user_mgmt/resources/views/public/verify-2fa.blade.php ENDPATH**/ ?>