    
<form class="box login" id="frmLogin" name="login-form" action="<?php echo url_for("@signin"); ?>" method="post">
    <?php echo $form['_csrf_token']->render(); ?>
    <fieldset class="boxBody">              
        <?php echo $form['usuario']->renderLabel(); ?><?php echo $form['usuario']->render(array('class' => 'w-180')); ?><?php echo $form['usuario']->renderError(); ?></li>
        </br>
        <?php echo $form['password']->renderLabel(); ?><?php echo $form['password']->render(); ?><?php echo $form['usuario']->renderError(); ?></li>               
    </br>
    <input type="submit" name="do-login" class="btnLogin" value="Login" tabindex="4">
    <?php echo $form->renderGlobalErrors(); ?>
    </fieldset>
    
</form>

      