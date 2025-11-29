<?php

use app\models\Libro;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Catálogo de Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $tipoUsuario = null; // Inicializamos la variable

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

            if ($tipoUsuario === 8 || $tipoUsuario === 21) {
                echo Html::a('Nuevo Libro <i class="fas fa-plus-circle"></i>', ['create'], ['class' => 'btn btn-success my-3']); // Agregar la clase my-2 para espacio vertical
            }
        }
        ?>
    </p>

        <?php $isDesktop = Yii::$app->request->userAgent && strpos(Yii::$app->request->userAgent, 'Mobile') === false; ?>

        <?php Pjax::begin(); ?>
      
   
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,  // Activar filtros para todas las columnas
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
            'maxButtonCount' => 5,
            'prevPageLabel' => 'Anterior',
            'nextPageLabel' => 'Siguiente',
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'page-item active',
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codigo_barras',
            [
                'attribute' => 'titulo',
                'filterInputOptions' => [
                    'class' => 'form-control', 
                    'placeholder' => 'Buscar título...'
                ],
            ],
            [
                'attribute' => 'autor',
                'filterInputOptions' => [
                    'class' => 'form-control', 
                    'placeholder' => 'Buscar autor...'
                ],
            ],
            [
                'attribute' => 'isbn',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Buscar ISBN...'
                ],
                'visible' => $isDesktop,
            ],
            [
                'attribute' => 'categoria_id',
                'value' => function ($model) {
                    return $model->categoria->Categoría;
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\Categoria::find()->orderBy(['Categoría' => SORT_ASC])->all(),
                    'id',
                    'Categoría'
                ),
            ],
            [
                'attribute' => 'asignatura_IdAsig',
                'value' => function ($model) {
                    return $model->asignatura->NombAsig;
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\Asignatura::find()->orderBy(['NombAsig' => SORT_ASC])->all(),
                    'IdAsig',
                    'NombAsig'
                ),
            ],
        /*    [
                'attribute' => 'pais_cod_pais',
                'value' => function ($model) {
                    return $model->getPais ? $model->getPais->nomb_pais : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\pais::find()->orderBy(['nomb_pais' => SORT_ASC])->all(),
                    'cod_pais',
                    'nomb_pais'
                ),
            ],*/
            // Más columnas si es necesario...

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>