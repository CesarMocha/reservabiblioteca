<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */

$this->title = 'Registro de Préstamo';
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
