<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Libro;

/**
 * LibroSearch represents the model behind the search form of `app\models\Libro`.
 */
class LibroSearch extends Libro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'n_ejemplares', 'biblioteca_idbiblioteca'], 'integer'],
            [['codigo_barras', 'titulo', 'autor', 'isbn', 'cute', 'editorial', 'anio_publicacion', 'estado', 'ubicacion', 'categoria_id', 'asignatura_IdAsig', 'pais_cod_pais'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Libro::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'anio_publicacion' => $this->anio_publicacion,
            'n_ejemplares' => $this->n_ejemplares,
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,
        ]);

        $query->andFilterWhere(['like', 'codigo_barras', "%{$this->codigo_barras}%", false])
        ->andFilterWhere(['like', 'titulo', "%{$this->titulo}%", false])
        ->andFilterWhere(['like', 'autor', "%{$this->autor}%", false])
        ->andFilterWhere(['like', 'isbn', "%{$this->isbn}%", false])
        ->andFilterWhere(['like', 'cute', "%{$this->cute}%", false])
        ->andFilterWhere(['like', 'editorial', "%{$this->editorial}%", false])
        ->andFilterWhere(['like', 'estado', "%{$this->estado}%", false])
        ->andFilterWhere(['like', 'ubicacion', "%{$this->ubicacion}%", false])
        ->andFilterWhere(['like', 'categoria_id', "%{$this->categoria_id}%", false])
        ->andFilterWhere(['like', 'asignatura_IdAsig', "%{$this->asignatura_IdAsig}%", false])
        ->andFilterWhere(['like', 'pais_cod_pais', "%{$this->pais_cod_pais}%", false]);
  
        return $dataProvider;
    }
}
