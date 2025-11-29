<?php

namespace app\controllers;

use app\models\Libro;
use app\models\LibroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\Asignatura;
use app\models\Prestamo;
use app\models\Biblioteca;
use Yii;

/**
 * LibroController implements the CRUD actions for Libro model.
 */
class LibroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Libro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LibroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libro model.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $biblioteca_idbiblioteca)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $biblioteca_idbiblioteca),
        ]);
    }

    /**
     * Creates a new Libro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Libro();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Libro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $biblioteca_idbiblioteca)
    {
        $model = $this->findModel($id, $biblioteca_idbiblioteca);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Libro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $biblioteca_idbiblioteca)
    {
        $this->findModel($id, $biblioteca_idbiblioteca)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Libro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return Libro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $biblioteca_idbiblioteca)
    {
        if (($model = Libro::findOne(['id' => $id, 'biblioteca_idbiblioteca' => $biblioteca_idbiblioteca])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*public function actionInfo()
    {
        $mes = Yii::$app->request->get('mes');
        $anio = Yii::$app->request->get('anio');
        $asignatura = Yii::$app->request->get('asignatura');
        $biblioteca = Yii::$app->request->get('biblioteca');

        // Crea un Query para la consulta de libros
        $query = (new Query())
            ->select(['l.titulo AS libro', 'COUNT(*) AS cantidad'])
            ->from('prestamo p')
            ->innerJoin('libro l', 'p.libro_id = l.id')
            ->innerJoin('asignatura a', 'l.asignatura_id = a.id');

        // Aplica condiciones basadas en los valores del formulario
        if ($mes && $anio) {
            $query->andWhere(['=', 'MONTH(p.fecha_solicitud)', $mes]);
            $query->andWhere(['=', 'YEAR(p.fecha_solicitud)', $anio]);
        }

        if ($asignatura) {
            $query->andWhere(['=', 'a.Nombre', $asignatura]);
        }

        if ($biblioteca) {
            $query->andWhere(['=', 'l.biblioteca_idbiblioteca', $biblioteca]);
        }

        // Ejecuta la consulta y obtiene los resultados
        $topBooksByAsignatura = $query
            ->groupBy(['l.titulo'])
            ->orderBy(['cantidad' => SORT_DESC])
            ->limit(10)
            ->all();

        $chartData = [
            'labels' => [], // Inicializa las etiquetas
            'data' => [],   // Inicializa los datos
        ];

        foreach ($topBooksByAsignatura as $item) {
            $chartData['labels'][] = $item['libro'];
            $chartData['data'][] = $item['cantidad'];
        }

        // Obtén la lista de meses y años para el formulario
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        $anios = array_unique((new Query())
            ->select('YEAR(fecha_solicitud) as anio')
            ->from('prestamo')
            ->distinct()
            ->orderBy(['anio' => SORT_DESC])
            ->column());

        $asignaturas = (new Query())
            ->select('Nombre')
            ->from('asignatura')
            ->column();

        // Corrige la consulta para obtener bibliotecas a través de la relación con Libro
        $bibliotecas = (new Query())
            ->select(['b.idbiblioteca', 'b.Campus'])
            ->from('libro l')
            ->leftJoin('biblioteca b', 'l.biblioteca_idbiblioteca = b.idbiblioteca')
            ->distinct()
            ->all();

        return $this->render('info', [
            'topBooksByAsignatura' => $topBooksByAsignatura,
            'meses' => $meses,
            'anios' => $anios,
            'mesSeleccionado' => $mes,
            'anioSeleccionado' => $anio,
            'bibliotecaSeleccionada' => $biblioteca,
            'asignaturaSeleccionada' => $asignatura,
            'asignaturas' => $asignaturas,
            'bibliotecas' => $bibliotecas,
            'chartData' => $chartData,
        ]);



    }*/

    
}
