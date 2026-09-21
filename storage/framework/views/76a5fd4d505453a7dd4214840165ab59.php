<?php $__env->startSection('title', 'Se connecter | Conceptic User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-center align-items-center" style="min-height:8ovh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Entrez vos identifiants</h4>
        <form action="<?php echo e(route('login.process')); ?>" method="post">
        <?php echo csrf_field(); ?>

        
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required autofocus>
            <?php $__errorArgs = ["email"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
               <div class="invalid-feeback"> <?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
       <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password"  name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
            <?php $__errorArgs = ["password"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feeback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
       </div>

       
        <div class="d-grid">
            <button type ="submit" class="btn btn-primary">Se connecter</button>
        </div>
        <center><p class="mt-2"><small>Pas de compte ?  <a href="<?php echo e(route('register.show')); ?>">Inscrivez-vous</a></small></p></center>
    </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('back'); ?>
    <div class="d-flex justify-content-center mt-5">  
       <a href="<?php echo e(route('index')); ?>"> <button class="btn btn-outline-primary ">Retourner à l'accueil</button></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    &copy; 2026 conceptic.io. Tous droits réservés.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Master 2024\Stage\conceptic_user_mgmt\resources\views/public/login.blade.php ENDPATH**/ ?>