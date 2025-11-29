<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios Registrados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php
        $tipoUsuario = null; // Inicializamos la variable

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

            if ($tipoUsuario === 8) {
                echo Html::a('Agregar Usuario <i class="fas fa-user-plus"></i>', ['create'], ['class' => 'btn btn-success my-3']);
            }
        }
        ?>
    </p>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'username',
                //'password',
                //'Auth_key',
                // 'Status',

                [
                    'attribute' => 'Status',
                    'value' => function ($model) {
                        if (($model->Status == 1)) {
                            return 'Activo';
                        } elseif (($model->Status == 0)) {
                            return 'Inactivo';
                        } else {
                            return 'N/A'; // Puedes definir un valor por defecto si ninguna condición se cumple.
                        }
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'Status', [
                        '1' => 'Activo',
                        '0' => 'Inactivo',
                    ], ['class' => 'form-control', 'prompt' => 'Todos']),
                ],
                //'tipo_usuario',
                [
                    'attribute' => 'tipo_usuario',
                    'value' => function ($model) {
                        if (($model->tipo_usuario == 1)) {
                            return 'Externo';
                        } elseif (($model->tipo_usuario == 13)) {
                            return 'Estudiante';
                        } elseif (($model->tipo_usuario == 18)) {
                            return 'Personal Universitario';
                        } elseif (($model->tipo_usuario == 21)) {
                            return 'Personal Biblioteca';
                        } elseif (($model->tipo_usuario == 7)) {
                            return 'Gerente';
                        } elseif (($model->tipo_usuario == 8)) {
                            return 'Administrador';
                        } else {
                            return 'N/A'; // Puedes definir un valor por defecto si ninguna condición se cumple.
                        }
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'tipo_usuario', [
                        '1' => 'Externo',
                        '13' => 'Estudiante',
                        '18' => 'Personal Universitario',
                        '21' => 'Personal Biblioteca',
                        '7' => 'Gerente',
                        '8' => 'Administrador',
                    ], ['class' => 'form-control', 'prompt' => 'Todos']),
                ],
                [
                    'attribute' => 'Created_at',
                    'value' => 'Created_at', // Mostrar el valor de Created_at
                    'filter' => Html::input('date', 'UserSearch[Created_at]', isset($searchModel->Created_at) ? $searchModel->Created_at : '', ['class' => 'form-control']),
                ],

                [
                    'attribute' => 'Updated_at',
                    'value' => 'Updated_at', // Mostrar el valor de Updated_at
                    'filter' => Html::input('date', 'UserSearch[Updated_at]', isset($searchModel->Updated_at) ? $searchModel->Updated_at : '', ['class' => 'form-control']),
                ],
                //'Temporalpassword',
                //'Tempralpasswordtime',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, User $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'visible' => $tipoUsuario === 8,
                ],
            ],
        ]); ?>


        <?php Pjax::end(); ?>

    </div>

</div>