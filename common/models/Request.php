<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $priority
 * @property string $description
 * @property string $contacts
 * @property string $comments
 * @property int $status
 * @property string $time_complete
 * @property string $time_working
 * @property int $mark
 *
 * @property RequestUser[] $requestUsers
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'priority', 'status', 'mark'], 'integer'],
            [['description', 'contacts', 'comments'], 'string'],
            [['time_complete', 'time_working'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['title', 'type', 'priority', 'contacts'], 'required'],
            ['status', 'default', 'value' => 0 ],
            ['mark', 'default', 'value' => 0 ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
            'priority' => 'Priority',
            'description' => 'Description',
            'contacts' => 'Contacts',
            'comments' => 'Comments',
            'status' => 'Status',
            'time_complete' => 'Time Complete',
            'time_working' => 'Time Working',
            'mark' => 'Mark',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestUsers()
    {
        return $this->hasMany(RequestUser::className(), ['request_id' => 'id']);
    }

    /*
     * Список типов заявки
     */
    public function getListType()
    {
        return [
            '0' => 'Сервисное обслуживание',
            '1' => 'Поддержка',
            '2' => 'Запрос технической информации',
        ];
    }

    /*
     * Список приоритетов заявки
     */
    public function getListPriority()
    {
        return [
            '0' => 'Низкий',
            '1' => 'Средний',
            '2' => 'Высокий',
        ];
    }

    /*
     * Список статусов заявки
     */
    public function getListStatus()
    {
        return [
            '0' => 'Новая',
            '1' => 'В работе',
            '2' => 'Выполнена',
            '3' => 'Отложена',
            '4' => 'Решена',
        ];
    }

    /*
     * Статус редактирования
     */
    public function getListMark()
    {
        return [
            '0' => 'Не редактируется',
            '1' => 'Редактируется',
        ];
    }
}
