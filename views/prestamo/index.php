<?php

use app\models\Prestamo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PrestamoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registros de Préstamo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestamo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $tipoUsuario = null; // Inicializamos la variable

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

            if ($tipoUsuario === 8 || $tipoUsuario === 21) {
                echo Html::a('Nuevo Préstamo <i class="fas fa-plus-circle"></i>', ['create'], ['class' => 'btn btn-success my-3']);
            }
        }
        ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel, // Habilitar los filtros en las columnas
            'pager' => [
                'options' => ['class' => 'pagination justify-content-center'],
                'maxButtonCount' => 5,
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'prevPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'linkOptions' => ['class' => 'page-link'],
                'activePageCssClass' => 'page-item active',
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                // Activar filtros en cada columna
                [
                    'attribute' => 'id',
                    'filter' => true, // Habilitar filtro en el campo ID
                ],
                [
                    'attribute' => 'fecha_solicitud',
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'fecha_solicitud',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control'],
                    ]),
                ],
                [
                    'attribute' => 'tipoprestamo_id',
                    'filter' => \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo'),
                    'value' => function ($model) {
                        return $model->tipoprestamo->nombre_tipo;
                    },
                ],
                [
                    'attribute' => 'pc_idpc',
                    'value' => function ($model) {
                        return $model->pc_idpc ? $model->pcIdpc->nombre : '';
                    },
                    'filter' => true, // Habilitar filtro
                ],
              /*   [
                    'attribute' => 'libro_id',
                    'value' => function ($model) {
                        return $model->libro ? $model->libro->codigo_barras : '';
                    },
                    'filter' => true, // Habilitar filtro
                ],*/ 
               [
                    'attribute' => 'libro_id',
                    'label' => 'Título del Libro', // Etiqueta para la columna
                    'value' => function ($model) {
                        return $model->libro ? $model->libro->titulo : '';  // Mostrar el título del libro
                    },
                    'filter' => Html::activeTextInput($searchModel, 'libroTitulo', ['class' => 'form-control']),  // Habilitar filtro por título
                ],
                [
                    'attribute' => 'Cédula Solicitante',
                    'value' => function ($model) {
                        return $model->personaldata_Ci
                            ?? $model->informacionpersonal_CIInfPer
                            ?? $model->informacionpersonal_d_CIInfPer;
                    },
                    'filter' => true, // Habilitar filtro
                ],
                [
                    'attribute' => 'Nombres Solicitante',
                    'value' => function ($model) {
                        if (!empty($model->personaldata_Ci)) {
                               
                            return $model->personaldata_Ci ? $model->personaldataCi->getNombre() : 'sin registro';
                          
                        } 
                        // Si no, verifica si informacionpersonal_CIInfPer no está vacío y es un objeto
                        elseif (!empty($model->informacionpersonalCIInfPer) ) {
                           
                                return  $model->informacionpersonalCIInfPer ? $model->informacionpersonalCIInfPer->getNombre() : 'sin registro'; 
                        } 
                        elseif (!empty($model->informacionpersonalDCIInfPer) ) {
                           
                            return  $model->informacionpersonalDCIInfPer ? $model->informacionpersonalDCIInfPer->getNombre() : 'sin registro'; 
                    } 
                        // Si ninguno está presente, retorna 'No Asignado'
                        return 'No Asignado';
                    },
                    'filter' => true, // Habilitar filtro
                ],
                
                [
                    'attribute' => 'facultad',
                    'label' => 'Facultad / Institucion',
                   'value' => function ($model) {
                        if (!empty($model->personaldata_Ci)) {
                                return $model->personaldata_Ci ? $model->personaldataCi->Institucion : 'Externo Sin Institucion';
                        } 
                         // Verificar si informacionpersonalCIInfPer, factura y detalleMatricula están definidos
                        elseif (!empty($model->informacionpersonalCIInfPer) && 
                                !empty($model->informacionpersonalCIInfPer->factura) && 
                                !empty($model->informacionpersonalCIInfPer->factura->detalleMatricula)) {
                                return $model->informacionpersonalCIInfPer->factura->detalleMatricula->carrera2->getNombreFacultad();
                        } 
                        elseif (!empty($model->informacionpersonalDCIInfPer)) {
                                return 'Docente Sin Asignación'; 
                        }

                        return 'Información no disponible';
                    },
                    'filter' => Html::activeTextInput($searchModel, 'facultad', ['class' => 'form-control']),
                ],
                
                [
                    'attribute' => 'carrera',
                    'label' => 'Carrera',
                    'value' => function ($model) {
                        if (!empty($model->personaldata_Ci)) {
                            return 'Externo Sin Asignación';
                        } elseif (!empty($model->informacionpersonalCIInfPer)) {
                            // Verifica que las relaciones 'factura' y 'detalleMatricula' existan antes de acceder a ellas
                            if ($model->informacionpersonalCIInfPer->factura !== null && $model->informacionpersonalCIInfPer->factura->detalleMatricula !== null) {
                                return $model->informacionpersonalCIInfPer->factura->detalleMatricula->getNombCarrera();
                            } else {
                                return 'Estudiante sin Carrera';
                            }
                        } elseif (!empty($model->informacionpersonalDCIInfPer)) {
                            return 'Docente Sin Asignación';
                        } else {
                            return 'Sin Información';
                        }
                    },
                    'filter' => Html::activeTextInput($searchModel, 'carrera', ['class' => 'form-control']),
                ],
                
                
                [
                    'attribute' => 'nivel',
                    'label' => 'Nivel',
                    'value' => function ($model) {
                        if (!empty($model->personaldata_Ci)) {
                            return 'Externo Sin Asignación';
                        } 
                        elseif (!empty($model->informacionpersonalCIInfPer)) {
                            // Verificar la existencia de 'factura' y 'detalleMatricula' antes de acceder a 'nivel'
                            $factura = $model->informacionpersonalCIInfPer->factura ?? null;
                            $detalleMatricula = $factura ? $factura->detalleMatricula ?? null : null;
                            
                            return $detalleMatricula ? $detalleMatricula->nivel : 'Estudiante sin Nivel';
                        } 
                        elseif (!empty($model->informacionpersonalDCIInfPer)) {
                            return 'Docente Sin Asignación';
                        }
                        return 'Sin Información';
                    },
                    'filter' => Html::activeTextInput($searchModel, 'nivel', ['class' => 'form-control']),
                ],
                
                [
                    'attribute' => 'tipoSolicitante',
                    'label' => 'Tipo de Solicitante',
                    'value' => function ($model) {
                        if (!empty($model->informacionpersonal_d_CIInfPer)) {
                            return 'Personal Universitario';
                        } elseif (!empty($model->personaldata_Ci)) {
                            return 'Externo';
                        } elseif (!empty($model->informacionpersonal_CIInfPer)) {
                            return 'Estudiante';
                        } else {
                            return 'N/A';
                        }
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'tipoSolicitante', [
                        'Personal Universitario' => 'Personal Universitario',
                        'Externo' => 'Externo',
                        'Estudiante' => 'Estudiante',
                    ], ['class' => 'form-control', 'prompt' => 'Seleccionar']),
                ],
                
                [
                    'attribute' => 'biblioteca_idbiblioteca',
                    'value' => function ($model) {
                        return $model->bibliotecaIdbiblioteca->Campus;
                    },
                    'filter' => \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Prestamo $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'visible' => $tipoUsuario === 8 || $tipoUsuario === 21,
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>
</div>
