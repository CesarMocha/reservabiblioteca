<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prestamo $model */
/** @var yii\widgets\ActiveForm $form */

date_default_timezone_set('America/Guayaquil'); // Configura la zona horaria de Ecuador (Quito)
?>

<style>
    .custom-form {
        background-color: #f7f7f7;
        padding: 20px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
    }

    .form-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
</style>

<div class="prestamo-form custom-form">
    <h1 class="form-title">Detalles de Solicitud</h1>

    <div id="form-message" style="display:none; color:red;"></div> <!-- Mensaje de error -->
    <div id="form-success-message" style="display:none; color:green;">Préstamo generado con éxito.</div> <!-- Mensaje de éxito -->

    <?php $form = ActiveForm::begin(['id' => 'prestamo-form']); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'biblioteca_idbiblioteca')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(\app\models\Biblioteca::find()->all(), 'idbiblioteca', 'Campus'),
                    ['prompt' => 'Seleccione Campus']
                ) ?>
                
            <?= $form->field($model, 'field_choice')->dropDownList([
                'personaldata_Ci' => 'Solicitante Externo',
                'informacionpersonal_CIInfPer' => 'Estudiante de la Institución',
                'informacionpersonal_d_CIInfPer' => 'Personal Universitario',
            ], ['prompt' => 'Seleccione Tipo de Solicitante'])->label('Tipo de Solicitante'); ?>

            <div id="dynamic-input-container"></div> <!-- Container for dynamic input fields -->

            <?= $form->field($model, 'tipoprestamo_id')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(\app\models\Tipoprestamo::find()->all(), 'id', 'nombre_tipo'),
                    ['prompt' => 'Servicio Solicitado', 'id' => 'tipoprestamo-id']
                ) ?>

            <div class="dynamic-fields" id="libro-fields" style="display: none">
                <?= $form->field($model, 'libro_id')
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Libro::find()->all(), 'id', function ($model) {
                            return $model->codigo_barras . ' - ' . $model->titulo;
                        }),
                        ['prompt' => 'Seleccione Libro']
                    ) ?>
            </div>

            <div class="dynamic-fields" id="pc-fields" style="display: none">
                <?= $form->field($model, 'pc_idpc')->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        \app\models\Pc::find()
                            ->where(['estado' => 'D'])
                            ->where(['biblioteca_idbiblioteca' => 1]) // Ajusta esta condición según sea necesario
                            ->all(),
                        'idpc',
                        'nombre'
                    ),
                    ['prompt' => 'Seleccione Dispositivo']
                ) ?>
            </div>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'intervalo_solicitado')
                ->textInput(['type' => 'time', 'value' => '01:00:00']) ?>

            <?= $form->field($model, 'fecha_solicitud')->input('datetime-local', [
                'value' => date('Y-m-d\TH:i', strtotime('now')), // Valor por defecto es la fecha y hora actual
            ])->label('Fecha y Hora de Solicitud'); ?>

        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btn-lg d-inline-block', 'style' => 'width: 48%;']) ?>
        <?= Html::button('Nuevo Préstamo', ['id' => 'new-loan-button', 'class' => 'btn btn-warning btn-lg d-inline-block', 'style' => 'width: 48%; margin-left: 2%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<<JS
// Función para mostrar los campos dinámicos basados en los valores del modelo
function showDynamicFields() {
    var personaldata_Ci = "{$model->personaldata_Ci}";
    var informacionpersonal_CIInfPer = "{$model->informacionpersonal_CIInfPer}";
    var informacionpersonal_d_CIInfPer = "{$model->informacionpersonal_d_CIInfPer}";

    if (personaldata_Ci !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[personaldata_Ci]" placeholder="Cédula de Persona Externa" value="' + personaldata_Ci + '">');
    } else if (informacionpersonal_CIInfPer !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[informacionpersonal_CIInfPer]" placeholder="Cédula de Estudiante" value="' + informacionpersonal_CIInfPer + '">');
    } else if (informacionpersonal_d_CIInfPer !== '') {
        $('#dynamic-input-container').html('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CIInfPer]" placeholder="Cédula de Personal Universitario" value="' + informacionpersonal_d_CIInfPer + '">');
    }
}

var isNewRecord = "{$model->isNewRecord}";

// Mostrar campos dinámicos en actualización
if (!isNewRecord) {
    showDynamicFields();
    var selectedTipoprestamo = $('#tipoprestamo-id').val();
    if (selectedTipoprestamo === 'LIB') {
        $('#libro-fields').show();
    } else if (selectedTipoprestamo === 'COMP') {
        $('#pc-fields').show();
    }
}

if (isNewRecord) {
    $('#prestamo-field_choice').on('change', function() {
        var choice = $(this).val();
        var container = $('#dynamic-input-container');
        container.empty();

        if (choice === 'personaldata_Ci') {
            container.append('<input type="text" class="form-control" name="Prestamo[personaldata_Ci]" placeholder="Cédula de Persona Externa">');
        } else if (choice === 'informacionpersonal_CIInfPer') {
            container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_CIInfPer]" placeholder="Cédula de Estudiante">');
        } else if (choice === 'informacionpersonal_d_CIInfPer') {
            container.append('<input type="text" class="form-control" name="Prestamo[informacionpersonal_d_CIInfPer]" placeholder="Cédula de Personal Universitario">');
        }
    });
}

// Controlar el cambio de tipo de préstamo
$('#tipoprestamo-id').on('change', function() {
    var selectedValue = $(this).val();
    if (selectedValue === 'LIB') {
        $('#libro-fields').show();
        $('#pc-fields').hide();
    } else if (selectedValue === 'COMP') {
        $('#pc-fields').show();
        $('#libro-fields').hide();
    } else {
        $('#libro-fields').hide();
        $('#pc-fields').hide();
    }
});

// Función para el botón "Nuevo Préstamo"
$('#new-loan-button').on('click', function() {
    // Recargar la página para limpiar el formulario
    location.reload();
});
JS;

$this->registerJs($script);
