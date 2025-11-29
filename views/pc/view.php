<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pc $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Pcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar PC', ['update', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'idpc',
            'nombre',
            'estado',
            //  'biblioteca_idbiblioteca',
            [
                'attribute' => 'biblioteca_idbiblioteca', // Esto muestra el código del país
                'value' => function ($model) {
                    return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre del país relacionado
                },
            ],
        ],
    ]) ?>

</div>
