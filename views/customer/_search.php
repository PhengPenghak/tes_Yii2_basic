<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SearchCustomer $model */
/** @var yii\widgets\ActiveForm $form */

?>


<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['id' => 'formCustomerSearch', 'data-pjax' => true],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'globalSearch',)->textInput(['aria-label' => 'Search', 'type' => 'search', 'class' => 'form-control search_global w-50', 'placeholder' => 'Search Customer.........',])->label(false) ?>

        </div>
    </div>
    <?php //echo $form->field($model, 'status')
    ?>
    <?php ActiveForm::end(); ?>
</div>
<?php


$script = <<<JS
    // $(document).on("change","#CustomerSearch-globalsearch", function(){
    //     $('#formCustomerSearch').trigger('submit');
    // });
    // var timeout = null
    // $('##CustomerSearch-globalsearch').on('keyup', function() {
    //     var text = this.value
    //     clearTimeout(timeout)
    //     timeout = setTimeout(function() {
    //         $('#formCustomerSearch').trigger('submit');
    //     }, 500)
    // });
JS;
$this->registerJs($script);
?>