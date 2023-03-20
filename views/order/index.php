<?php

use app\helpers\OrderFilterHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\forms\OrderFilterForm $filterForm */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <?php
        Pjax::begin(['id' => 'orders']); ?>
        <div class="row">
            <div class="col-sm-2">
                <?= OrderFilterHelper::renderFilterMenu($filterForm); ?>
            </div>
            <div class="col-sm-10">
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => null,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'sum',
                            'created_at',
                            [
                                    'class'    => ActionColumn::class,
                                    'template' => '{view}',
                            ],
                        ],
                ]); ?>
            </div>
        </div>
        <?php
        Pjax::end(); ?>
    </div>
</div>
