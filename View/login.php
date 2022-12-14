<?php 
/**
 * @var $model \app\Model\LoginForm
 */
;?>

<h1 class="text-muted">Login!</h1>
<?php $form = \app\core\form\Form::begin('', 'POST') ;?>
    <?php echo $form->field($model, 'email')->emailFiled();?>
    <?php echo $form->field($model, 'password')->passwordFiled();?>
<br>
<button type="submit" class="btn btn-primary">Login</button>
<div>
    <small class="text-primary">Not having account? <a href="\register">click here</a></small>
</div>
<?php \app\core\form\Form::end();?>
