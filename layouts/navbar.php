<!-- Navbar -->
<?php

use yii\helpers\Html;
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"> <i class="fas fa-clock"></i>&nbsp;&nbsp; Horarios de Atención</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=1']) ?>" class="dropdown-item">Esmeraldas</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=3']) ?>" class="dropdown-item">Mutiles</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?= \yii\helpers\Url::to(['/biblioteca/view?idbiblioteca=2']) ?>" class="dropdown-item">La Concordia</a></li>
            </ul>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::to(['/site/about']) ?>" class="nav-link">Acerca de Nosotros</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>

        <!--<li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>-->


    </ul>
</nav>
<!-- /.navbar -->