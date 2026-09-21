<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Activation de compte</title>
    </head>
    <body>
        <h2>Bienvenue <?php echo e($user->name); ?></h2>
        <p>Merci de vous inscrit sur Conceptic.io</p>
        <p>Pour activer votre compte et accéder à votre tableau de bord, cliquez sur le lien  ci dessous :</p>
        <p>
            <a href="<?php echo e($activationUrl); ?>" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Activer mon compte
            </a>
        </p>
        <p>Si vous n'avez pas demandé cette inscription, ignorez simplement ce message.</p>
    </body>
</html>
<?php /**PATH K:\Master IFRI\Stage\conceptic_user_mgmt\resources\views/emails/activation.blade.php ENDPATH**/ ?>