<?php

use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Список заявок';
?>
<div class="site-index">

    <h1><?= $this->title ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    foreach ($model->getListType() as $key => $item) {
                        if ($key === $model->{$column->attribute}) {
                            return $item;
                        }
                    }
                },
            ],
            [
                'attribute' => 'priority',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    foreach ($model->getListPriority() as $key => $item) {
                        if ($key === $model->{$column->attribute}) {
                            return $item;
                        }
                    }
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => $model->getListStatus(),
                'value' => function ($model, $key, $index, $column) {
                    foreach ($model->getListStatus() as $key => $item) {
                        if ($key === $model->{$column->attribute}) {
                            return $item;
                        }
                    }
                },
            ],
            [
                'attribute' => 'time_complete',
                'format' => ['time', 'php:H:i:s'],
            ],
            [
                'attribute' => 'mark',
                'format' => 'raw',
                'filter' => $model->getListMark(),
                'value' => function ($model, $key, $index, $column) {
                    foreach ($model->getListMark() as $key => $item) {
                        if ($key === $model->{$column->attribute}) {
                            if ($model->{$column->attribute} ===  1) {
                                return "$item: ".$model->requestUsers[0]->user->username;
                            } else {
                                return $item;
                            }
                        }
                    }
                },
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => "{view} {update}",
                'urlCreator' => function ($action, $model, $key, $index) {
                    return \yii\helpers\Url::to(['site/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]);
    ?>

</div>
