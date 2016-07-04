<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model spanjeta\seomanager\models\Seomanager */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="seo-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="form-group field-seomanager-route required has-success">
<label for="seomanager-route" class="control-label">Select Route/Url Category</label>
<?=Html::dropDownList ( 'c_id', null,ArrayHelper::map (  $model->getAvailableControllers(), 'controller', 'controller' ), [ 'class' => 'form-control','id' => 'w_id','prompt' => 'Select a category of route' ] );?>

</div>

    <?= $form->field($model, 'route')->dropDownList ( array(), [ 'prompt' => 'Select a route' ] ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'placeholder' => 'Comma separated']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'canonical')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php if (!$model->isNewRecord && $this->context->module->cache): ?>

            <?= Html::a('<span class="glyphicon glyphicon-flash" aria-hidden="true"></span> Clear Cache', ['seomanager/clear-cache', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'title' => 'clear cache',
                'arial-label' => 'Left Align'
            ]); ?>

        <?php endif ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

$('#w_id').change(function(){
	var val = $(this).val();
	var url = "<?= Url::to(['seomanager/route'])?>";
	$.ajax({
		url : url,
		type:'GET',
		data:{title:val},
		success:function(response){
			 $('#seomanager-route').html('');
		 		var obj = response.url;
console.log(response.url);
			 $('#seomanager-route')
		         .append($("<option value='"+response.url+"'> Select Route</option>"));
 			$.each(obj, function(key, value) {   
 				 $('#seomanager-route')
 			         .append($("<option></option>")
 			         .attr("value",key)
 			         .text(value)); 
 			});
			}
		});
});

</script>
