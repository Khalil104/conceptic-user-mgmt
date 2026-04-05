

<?php $__env->startSection('title', 'S\'inscrire | Conceptic User Management'); ?>


<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center align-items-center" style="min-height:8ovh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width:500px;">
            <h4 class="text-center mb-4">Inscrivez-vous maintenant !</h4>
             <form action="<?php echo e(route('register.process')); ?>" method="post">
                <?php echo csrf_field(); ?>

                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom et prénom(s)</label>
                    <input type="text" id="name" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ["name"];
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
                
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="text" id="email"  name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ["email"];
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
                
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
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
                
                
                 
                
                
                <div class="mb-3">
                    <label for="role" class="form-label">Choisissez votre rôle</label>
                    <select name="role" id="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalide <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="" disabled selected>-- Selectionnez --</option>
                        <option value="user" <?php echo e(old('role') == 'user' ? 'selected' : ''); ?>>Utilisateur</option>
                        <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>"> Administrateur</option>
                    </select>
                    <?php $__errorArgs = ["role"];
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
                
                
                <div class="mb-3">
                    <label for="status" class="form-label">Choisissez votre statut</label>
                    <select name="status" id="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="" disabled selected>--Selectionnez --</option>
                        <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Actif</option>
                        <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Inactif</option>
                        <option value="suspended" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Suspendu</option>
                        <option value="deleted" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Supprimé</option>
                    </select>
                    <?php $__errorArgs = ["role"];
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
                    <button type ="submit" class="btn btn-primary">Créer mon compte</button>
                </div>
                <center><p class="mt-2"><small>Déjà un compte ?  <a href="<?php echo e(route('login.show')); ?>">Connectez-vous</a></small></p></center>
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
 
   

<?php echo $__env->make('base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Master_IFRI\STAGE\Conceptic.io\conceptic_user_mgmt\resources\views/public/register.blade.php ENDPATH**/ ?>