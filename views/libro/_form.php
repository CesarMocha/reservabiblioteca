<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use app\models\Asignatura;
use app\models\Pais;
use app\models\Biblioteca;

/** @var yii\web\View $this */
/** @var app\models\Libro $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libro-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'custom-form']]); ?>
    <h2 class="form-title">Detalles del Libro</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'n_ejemplares')
                    ->label('Número de Ejemplares')
                    ->input('number', ['max' => 10, 'step' => 1, 'class' => 'form-control', 'placeholder' => 'Número de Ejemplares']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'codigo_barras')
                    ->label('Código de Barras')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Código de Barras']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'titulo')
                    ->label('Título')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Título de la Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'autor')
                    ->label('Autor')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Autor de la Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'isbn')
                    ->label('ISBN')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'ISBN']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'cute')
                    ->label('CUTE')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'CUTE']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'editorial')
                    ->label('Editorial')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Editorial']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= $form->field($model, 'anio_publicacion')
                    ->label('Año de Publicación')
                    ->input('number', ['max' => date('Y'), 'step' => 1, 'class' => 'form-control', 'placeholder' => 'Año de Publicación']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'estado')
                    ->label('Estado')
                    ->dropDownList([
                        'B' => 'Bueno',
                        'R' => 'Regular',
                        'M' => 'Malo'
                    ], ['prompt' => 'Seleccione el estado', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'categoria_id')
                    ->label('Categoría')
                    ->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'Categoría'), ['prompt' => 'Seleccione la categoría', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'asignatura_IdAsig')
                    ->label('Asignatura')
                    ->dropDownList(ArrayHelper::map(Asignatura::find()->all(), 'IdAsig', 'NombAsig'), ['prompt' => 'Seleccione la asignatura', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'pais_cod_pais')
                    ->label('País')
                    ->dropDownList(ArrayHelper::map(Pais::find()->orderBy(['nomb_pais' => SORT_ASC])->all(), 'cod_pais', 'nomb_pais'), ['prompt' => 'Seleccione el país', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'biblioteca_idbiblioteca')
                    ->label('Campus')
                    ->dropDownList(ArrayHelper::map(Biblioteca::find()->all(), 'idbiblioteca', 'Campus'), ['prompt' => 'Seleccione el campus', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'ubicacion')
                    ->label('Ubicación')
                    ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Estante']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

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