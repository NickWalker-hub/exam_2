<?php

use app\models\Request;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Car;
use yii\widgets\ListView;


/** @var yii\web\View $this */
/** @var app\models\RequestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои заявки';
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

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['lk/index'], 'options' => ['class' => 'request-index__search']]); ?>

        <?= $form->field($searchModel, 'id_car')->dropDownList(ArrayHelper::map(Car::find()->all(), 'id', 'name'), ['prompt' => 'Выберите авто'])->label('Авто') ?>

        <?= $form->field($searchModel, 'backing_date')->textInput(['type' => 'date']) ?>


        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function ($model, $key, $index, $widget) {
            return '<p>Дата бронирования: ' . Html::encode($model->backing_date) . '</p>'
                . '<p>Выбранный авто: ' . Html::encode($model->car->name) . '</p>'
                . '<p>Статус заявки: ' . Html::encode($model->status->name) . '</p>';
        },
        'summary' => '',
        'pager' => [
            'class' => \yii\widgets\LinkPager::className(),
        ],
    ]); ?>
</div>

