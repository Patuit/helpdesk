<?php
$this->title = 'Просмотр заявки';
?>
<div class="col-lg-8 col-lg-offset-2 view-request">
    <h1>Просмотр данных о заявке</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <td style="width: 200px">id</td>
                <td><?= $model->id ?></td>
            </tr>
            <tr>
                <td>Название заявки</td>
                <td><?= $model->title ?></td>
            </tr>
            <tr>
                <td>Тип заявки</td>
                <td><?php foreach ($model->getListType() as $key => $item) {
                        if ($key === $model->type) {
                            echo $item;
                        }
                    } ?></td>
            </tr>
            <tr>
                <td>Приоритет заявки</td>
                <td><?php foreach ($model->getListPriority() as $key => $item) {
                        if ($key === $model->priority) {
                            echo $item;
                        }
                    } ?></td>
            </tr>
            <tr>
                <td>Описание заявки</td>
                <td><?= $model->description ?></td>
            </tr>
            <tr>
                <td>Контактные данные</td>
                <td><?= $model->contacts ?></td>
            </tr>
            <tr>
                <td>Комментарий</td>
                <td><?= $model->comments ?></td>
            </tr>
            <tr>
                <td>Статус заявки</td>
                <td><?php foreach ($model->getListStatus() as $key => $item) {
                        if ($key === $model->status) {
                            echo $item;
                        }
                    } ?></td>
            </tr>
            <tr>
                <td>Время на выполнение</td>
                <td><?= $model->time_complete ?></td>
            </tr>
            <tr>
                <td>Затраченное время</td>
                <td><?= $model->time_working ?></td>
            </tr>
            <tr>
                <td>Последний, кто редактировал:</td>
                <td><?= $model->getRequestUsers()->with('user')->one()->user->username ?></td>
            </tr>
        </table>

            <?php if (date($model->time_complete) < date($model->time_working)) {
                print_r('
                <p class="bg-danger">
                Время на выполнение задачи превышено!;
                </p>
                ');
            } ?>

    </div>
</div>