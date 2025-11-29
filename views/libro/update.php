<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */

$this->title = 'Actualizar Libro: ' . $model->codigo_barras . ' - '. $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
