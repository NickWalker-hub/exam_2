<?php

use app\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Car;
use app\models\Status;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\RequestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Все заявки';
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /* Поиск */
    .request-index__search{
        display: flex;
        flex-direction: row;
        align-items: flex-end;
    }
    /* Форма поска */
    .form-group{
        margin: 0 10px;
    }
    /* Отдельная заявка */
    .list-view > div {
    border: 1px solid green;
    padding: 10px;
    margin: 20px 0;
    border-radius: 10px;
}
</style>

<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['request/index'], 'options' => ['class' => 'request-index__search']]); ?>

        <?= $form->field($searchModel, 'id_car')->dropDownList(ArrayHelper::map(Car::find()->all(), 'id', 'name'), ['prompt' => 'Выберите авто']) ?>

        <?= $form->field($searchModel, 'id_status')->dropDownList(ArrayHelper::map(Status::find()->all(), 'id', 'name'), ['prompt' => 'Выберите статус'])->label('Статус') ?>

        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget) {
            $buttons = '';
            if ($model->id_status == '1') {
                $buttons .= Html::a('Подтвердить', ['solve', 'id' => $model->id], ['class' => 'btn btn-success', 'style' => 'margin-right: 5px;']);
                $buttons .= Html::a('Отклонить', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
            return '<p>ФИО подавшего: ' . Html::encode($model->user->fio) . '</p>'
                . '<p>Телефон подавшего: ' . Html::encode($model->user->phone) . '</p>'
                . '<p>Почта подавшего:' . Html::encode($model->user->email) . '</p>'
                . '<p>Выбранный авто: ' . Html::encode($model->car->name) . '</p>'
                . '<p>Дата бронирования: ' . html::encode($model->backing_date) . '</p>'
                . '<p>Статус заявки: ' . Html::encode($model->status->name) . '</p>'
                . $buttons;
        },

    ]); ?>


</div>
