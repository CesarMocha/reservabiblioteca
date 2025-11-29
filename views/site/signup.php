<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registro';

$this->registerCss("
@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');

body {
    background-image: url('/img/3.jpeg'); /* Reemplaza con la ruta real de tu imagen de fondo */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
.registro-form {
    max-width: 90vw;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f8ff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.registro-form label {
    font-weight: 700;
}

.registro-form .form-group {
    margin-bottom: 20px;
}

.registro-form .btn-primary {
    background-color: #5EB400;
    color: #FFF;
    padding: 15px 20px;
    border: none;
}

.registro-form .btn-primary:hover {
    background-color: #4E9A00;
}

/* Estilo adicional para el título */
.registro-title {
    font-size: 2em;
    margin: 20px 0;
    color: #191970; /* Color del texto para el título */
    font-family: 'Raleway', sans-serif;
    font-size: 2em;
    font-weight: 700;
    letter-spacing: 2px; /* Ajusta el espaciado entre letras */
    text-transform: uppercase; /* Convierte el texto a mayúsculas, si es necesario */

}
");

?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
<?= \hail812\adminlte\widgets\Alert::widget([
    'type' => 'danger',
    'title' => 'Error', 
    'body' => Yii::$app->session->getFlash('error'),
]) ?>
<?php endif; ?>

<div class="registro-form">
    <h1 class="registro-title"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= $form->field($model, 'Ci')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Apellidos')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Nombres')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'FechaNacimiento')->input('date') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Genero')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino'], ['prompt' => 'Seleccione su género']) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Institucion')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'Nivel')->dropDownList($niveles, ['prompt' => 'Seleccione su Nivel Académico']) ?>
    </div>

<div class="form-group">
    <button id="submitButton" class="btn btn-primary">Iniciar Registro</button>
</div>

    <?php ActiveForm::end(); ?>

    
<script>
    // Agrega un evento de clic al botón de envío
    document.getElementById("submitButton").addEventListener("click", function(event) {
        // Pregunta al usuario si está seguro de realizar la acción
        if (confirm("¿Estás seguro de que deseas unirte a esta comunidad?")) {
            // Si el usuario hace clic en "Aceptar" en el cuadro de confirmación, se envía el formulario
            // Si el usuario hace clic en "Cancelar", no se envía el formulario
            // Puedes poner aquí el código para enviar el formulario si se confirma
        } else {
            // Cancela el evento de clic para que el formulario no se envíe
            event.preventDefault();
        }
    });
</script>

</div>

