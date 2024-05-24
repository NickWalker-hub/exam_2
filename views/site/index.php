<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style>
    .img-car{
        width: 500px;
        max-width: 100%;
    }
    .img-car-min{
        width: 50px;
    }
    /* Печатающийся текст */
    .site-index__title{
        width: 18em;
        max-width: 100%;
        /* font-size: clamp(52px, 1em, 12px); */

        /* color:green; */
        white-space:nowrap;
        overflow:hidden;
        -webkit-animation: type 5s steps(50, end);
        animation: type 5s steps(50, end);

    }

    @keyframes type{
        from { width: 0; }
    }
    /* Кнопка */
    .pulser {
    color: black;
    padding: 10px 20px;
    background: #adebad;
    position: relative;
    }

    .pulser::after {
    animation: pulse 1000ms cubic-bezier(0.9, 0.7, 0.5, 0.9) infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 0;
        }
        50% {
            transform: scale(1.4);
            opacity: 0.4;
        }
    }

    .pulser::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: green;
    z-index: -1;
    }

    .margin-desc{
        margin-top: 50px;
    }
</style>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4 site-index__title">Эх, прокачу!</h1>

        <p class="lead">Перед тем как впервые воспользоваться услугами сервиса вы должны зарегистрироваться.</p>

        <img src="/web/img/w.jpg" alt="logo" class="img-car"/>

        <p class="margin-desc">
            <?= Html::a('Зарегистрироваться', ['/user/create'], ['class' => 'btn pulser']) ?>
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>15 лет</h2>

                <p>Более 15 лет работы в прокатном бизнесе</p>

                <img src="/web/img/w.jpg" alt="logo" class="img-car-min">
            </div>
            <div class="col-lg-4">
                <h2>24 / 7</h2>

                <p>Круглосуточная выдача и возврат автомобиля.  
                (осуществляется только по предварительной договоренности).</p>

                <img src="/web/img/w2.jpg" alt="logo" class="img-car-min">
            </div>
            <div class="col-lg-4">
                <h2>7000 +</h2>

                <p>Более 7000 счастливых клиентов</p>

                <img src="/web/img/w3.jpg" alt="logo" class="img-car-min">
            </div>
        </div>

    </div>
</div>
