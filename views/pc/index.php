<?php

use app\models\Pc;
use app\models\Biblioteca;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\PcSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista de Computadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $tipoUsuario = null; // Inicializamos la variable

        if (!Yii::$app->user->isGuest) {
            // El usuario ha iniciado sesión, podemos acceder a 'tipo_usuario'
            $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

            if ($tipoUsuario === 8 || $tipoUsuario === 21) {
                echo Html::a('Agregar PC <i class="fas fa-plus-circle"></i>', ['create'], ['class' => 'btn btn-success my-3']);
            }
        }
        ?>

    </p>

    <div class="table-responsive">

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'options' => ['class' => 'pagination justify-content-center'], // Agrega una clase CSS personalizada al contenedor de paginación
                'maxButtonCount' => 5, // Controla el número de botones de página que se muestran
                'prevPageLabel' => 'Anterior',
                'nextPageLabel' => 'Siguiente',
                'prevPageCssClass' => 'page-item', // Clase CSS para el botón "Anterior"
                'nextPageCssClass' => 'page-item', // Clase CSS para el botón "Siguiente"
                'linkOptions' => ['class' => 'page-link'], // Agrega una clase CSS personalizada a los enlaces de página
                'activePageCssClass' => 'page-item active', // Clase CSS para la página activa
                'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'], // Estilo de los botones deshabilitados

            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'idpc',
                'nombre',
                [
                    'attribute' => 'estado',
                    'value' => function ($model) {
                        $estados = [
                            'D' => 'Disponible',
                            'ND' => 'No Disponible',
                            'F' => 'Fuera de servicio',
                            'EM' => 'En Mantenimiento',
                            'R' => 'Retirada',
                        ];

                        return isset($estados[$model->estado]) ? $estados[$model->estado] : $model->estado;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'estado', [
                        'D' => 'Disponible',
                        'ND' => 'No Disponible',
                        'F' => 'Fuera de servicio',
                        'EM' => 'En Mantenimiento',
                        'R' => 'Retirada',
                    ], ['class' => 'form-control', 'prompt' => 'Todos']),
                ],
                [
                    'attribute' => 'biblioteca_idbiblioteca',
                    'value' => function ($model) {
                        return $model->bibliotecaIdbiblioteca->Campus; // Accede al nombre de la biblioteca
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'biblioteca_idbiblioteca',
                        \yii\helpers\ArrayHelper::map(Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                        ['class' => 'form-control', 'prompt' => 'Todos']
                    ),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{prestar}',
                    'buttons' => [
                        'prestar' => function ($url, $model, $key) {
                            $buttonId = 'open-modal-button-' . $model->idpc; // Id único para el botón
                            return Html::button('<i class="fas fa-plus"></i>', [
                                'class' => 'btn btn-success',
                                'id' => $buttonId, // Id único para cada botón
                                'data-toggle' => 'modal',
                                'data-target' => '#prestamo-modal',
                                'data-remote' => Url::to(['/prestamo/prestarpc', 'id' => $model->idpc]),
                            ]);
                        },
                    ],
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Pc $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'idpc' => $model->idpc, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                    },
                    'visible' => $tipoUsuario === 8 || $tipoUsuario === 21,
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>

<div class="modal fade" id="prestamo-modal" tabindex="-1" role="dialog" aria-labelledby="prestamo-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prestamo-modal-label"><i class="fas fa-desktop"></i> Préstamo de Computador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal cargado a través de AJAX -->
                <div id="prestamo-modal-content"></div>
            </div>
        </div>
    </div>
</div>

<?php
// Registro de JS para manejar la apertura del modal
$this->registerJs('
    $("button[id^=open-modal-button-]").on("click", function () {
        var buttonId = $(this).attr("id");
        var pcId = buttonId.split("-").pop(); // Obtener el ID de la PC
        var modalContent = $("#prestamo-modal-content");

        modalContent.load($(this).data("remote"), function() {
            // Una vez que se carga el contenido en el modal, escuchamos el evento clic del botón "Enviar".
            modalContent.find("#submit-button").on("click", function (e) {
                e.preventDefault(); // Prevenir el envío automático del formulario
                // Aquí puedes realizar validaciones del formulario si es necesario
                // Si las validaciones son exitosas, puedes enviar el formulario con AJAX

                $.ajax({
                    type: "POST",
                    url: "/prestamo/prestarpc", // Reemplaza con la URL correcta
                    data: $("#prestamo-formulario").serialize(), // Reemplaza "tu-formulario" con el ID de tu formulario
                    success: function (data) {
                        // Manejar la respuesta si es necesario
                    }
                });
            });
        });
    });
');
?>