<?php 
/**
 * @var $model \app\Model\User
 */
;?>


<h1 class="text-muted">Create an account</h1>
<?php $form = \app\core\form\Form::begin('', 'POST') ;?>
<div class="row">
  <div class="col">
    <?php echo $form->field($model, 'name');?>
  </div>
  <div class="col">
    <?php echo $form->field($model, 'email')->emailFiled();?>
  </div>
</div>
<?php echo $form->field($model, 'password')->passwordFiled();?>
<?php echo $form->field($model, 'repassword')->passwordFiled();?>
<br>
<button type="submit" class="btn btn-primary">register</button>

<?php \app\core\form\Form::end();?>
