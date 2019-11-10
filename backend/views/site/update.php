<?php

use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Request */
/* @var $form ActiveForm */
$this->title = 'Редактирование заявки';
?>
    <!--<script>-->
    <!--    var second = 0;-->
    <!--    function myClock() {-->
    <!--        second += 1;-->
    <!--    }-->
    <!--    setInterval(myClock, 1000);-->
    <!--</script>-->
    <div class="col-lg-8 col-lg-offset-2 backend-site-view">
        <h1><?= $this->title ?></h1>

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('Название'); ?>
        <?= $form->field($model, 'type')->dropDownList($model->getListType())->label('Тип'); ?>
        <?= $form->field($model, 'priority')->dropDownList($model->getListPriority())->label('Приоритет'); ?>
        <?= $form->field($model, 'status')->dropDownList($model->getListStatus())->label('Статус'); ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание'); ?>
        <?= $form->field($model, 'comments')->textarea(['rows' => 6])->label('Комментарий'); ?>
        <?= $form->field($model, 'contacts')->textInput(['autofocus' => true])->label('Контактные данные'); ?>
        <?= $form->field($model, 'time_complete')->widget(TimePicker::className(), [
            'value' => $model->time_complete,
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
            ],
            'addonOptions' => [
                'asButton' => true,
                'buttonOptions' => ['class' => 'btn btn-info']
            ]
        ])->label('Время на обработку'); ?>
        <?= $form->field($model, 'time_working')->widget(TimePicker::className(), [
            'pluginOptions' => [
                'showSeconds' => true,
                'showMeridian' => false,
                'minuteStep' => 1,
                'template' => false
            ],
            'addonOptions' => [
                'asButton' => true,
                'buttonOptions' => ['class' => 'btn btn-info']
            ],
            'options' => [
                'readonly' => true,
            ],
        ])->label('Затраченное время'); ?>
        <?php if (date($model->time_complete) < date($model->time_working)) {
            print_r('
                <p class="bg-danger">
                Время на выполнение задачи превышено!;
                </p>
                ');
        } ?>
        <div class="form-group">
            <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div><!-- backend-site-view -->
<?php
$js = <<<JS
    function getFunc(key) {
        var p = window.location.search;
        p = p.match(new RegExp(key + '=([^&=]+)'));
        return p ? p[1] : false;
    };
// Когда покидаем страницу, то сбрасывем метку "Редактируется"
    window.onbeforeunload = function() {
       $.ajax({
            type: "POST",
            url: "index.php?r=site/unload",
            data: {'id': getFunc('id')}
        });
    };
    
    var outTimer = document.getElementById('request-time_working'),
        rawTime = "$model->time_working",
        serDay = 24 * 3600,
        arr = rawTime.split(":"),
        diff = parseInt(arr[0]) * 3600 + parseInt(arr[1]) * 60 + parseInt(arr[2]);
    setInterval(function () {
        diff++;
        var hours = Math.floor(diff / 3600),
            minutes = Math.floor(diff / 60) % 60,
            seconds = Math.floor(diff) % 60;
        if (hours < 10) hours = '0' + hours;
        if (minutes < 10) minutes = '0' + minutes;
        if (seconds < 10) seconds = '0' + seconds;
        if (diff === serDay) {
            diff = 0;
        }
        outTimer.value = hours + ':' + minutes + ':' + seconds;
    }, 1000);
JS;
$this->registerJs($js);
?>