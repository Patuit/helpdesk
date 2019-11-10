<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\time\TimePicker;
$this->title = 'Оставить заявку';
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('Название'); ?>

            <?= $form->field($model, 'type')->dropDownList($model->getListType())->label('Тип'); ?>

            <?= $form->field($model, 'priority')->dropDownList($model->getListPriority())->label('Приоритет'); ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание'); ?>

            <?= $form->field($model, 'contacts')->textInput(['autofocus' => true])->label('Контактные данные'); ?>

            <?= $form->field($model, 'time_complete')->widget(TimePicker::className(), [
                'pluginOptions' => [
                    'defaultTime' => '00:00:00',
                    'showSeconds' => false,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'autoclose' => true
                ],
                'addonOptions' => [
                    'asButton' => true,
                    'buttonOptions' => ['class' => 'btn btn-info']
                ]
            ])->label('Время на обработку'); ?>

            <div class="form-group">
                <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
