<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>   
   
<?php $form = ActiveForm::begin(); ?>   
   
    <?= $form->field($model, 'first_name'); ?>   
    <?= $form->field($model, 'last_name'); ?>   
       
      
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>   
   
   <?php ActiveForm::end(); ?> 