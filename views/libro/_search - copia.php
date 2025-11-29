<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LibroSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // $form->field($model, 'id') 
    ?>

    <?php // $form->field($model, 'codigo_barras') 
    ?>

    <?php // $form->field($model, 'titulo') 
    ?>

    <?php // $form->field($model, 'autor') 
    ?>

    <?php // $form->field($model, 'isbn') 
    ?>

    <?php // echo $form->field($model, 'cute') 
    ?>

    <?php // echo $form->field($model, 'editorial') 
    ?>

    <?php // echo $form->field($model, 'anio_publicacion') 
    ?>

    <?php // echo $form->field($model, 'estado') 
    ?>

    <?php // echo $form->field($model, 'n_ejemplares') 
    ?>

    <?php // echo $form->field($model, 'link') 
    ?>

    <?php // echo $form->field($model, 'categoria_id') 
    ?>

    <?php // echo $form->field($model, 'asignatura_IdAsig') 
    ?>

    <?php // echo $form->field($model, 'pais_cod_pais') 
    ?>

    <?php // echo $form->field($model, 'biblioteca_idbiblioteca') 
    ?>



    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'titulo')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Nombre del Libro'])->label('Título') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'autor')->textInput(['style' => 'width: 100%;', 'placeholder' => 'Autor de la Publicación'])->label('Autor') ?>
        </div>
    </div>
    <?php // echo $form->field($model, 'link') 
    ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'categoria_id')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        \app\models\Categoria::find()->orderBy(['Categoría' => SORT_ASC])->all(),
                        'id',
                        'Categoría'
                    ),
                    ['prompt' => 'Seleccionar Categoría', 'style' => 'width: 100%;']
                )->label('Categoría') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'asignatura_IdAsig')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        \app\models\Asignatura::find()->orderBy(['NombAsig' => SORT_ASC])->all(),
                        'IdAsig',
                        'NombAsig'
                    ),
                    ['prompt' => 'Seleccionar Asignatura', 'style' => 'width: 100%;']
                )->label('Asignatura') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php $paisesConLibros = \app\models\Pais::find()
                ->where(['IN', 'cod_pais', \app\models\Libro::find()->select('pais_cod_pais')->distinct()])
                ->orderBy(['nomb_pais' => SORT_ASC])
                ->all();
            ?>

            <?= $form->field($model, 'pais_cod_pais')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map($paisesConLibros, 'cod_pais', 'nomb_pais'),
                    ['prompt' => 'Seleccionar País', 'style' => 'width: 100%;']
                )
                ->label('País de Publicación') ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'anio_publicacion')
                ->textInput(['style' => 'width: 100%;', 'placeholder' => 'Año de Publicación', 'type' => 'number', 'min' => 1900, 'max' => date('Y')])
                ->label('Año de Publicación') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'codigo_barras')
                ->textInput(['style' => 'width: 100%;', 'placeholder' => 'Código Interno'])
                ->label('Código de Barras <i class="fas fa-barcode"></i>') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'isbn')->textInput(['style' => 'width: 100%;', 'placeholder' => 'ISBN de la Publicación'])->label('ISBN') ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-search"></i> Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Restablecer', ['class' => 'btn btn-outline-secondary', 'id' => 'reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<< JS
document.getElementById('reset-button').addEventListener('click', function() {
    var inputs = document.querySelectorAll('input[type="text"], input[type="date"], select'); // Obtener todos los campos de filtro
    inputs.forEach(function(input) {
        input.value = ''; // Limpiar los valores
    });

    // Enviar el formulario después de restablecer los campos
    document.querySelector('form').submit();
});
JS;
$this->registerJs($js);
?>