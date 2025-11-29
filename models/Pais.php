<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property string $codigopais
 * @property string $Nombrepais
 *
 * @property Libro[] $libros
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_pais', 'nomb_pais'], 'required'],
            [['cod_pais'], 'string', 'max' => 4],
            [['nomb_pais'], 'string', 'max' => 45],
            [['cod_pais'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_pais' => 'Cod_pais',
            'nomb_pais' => 'Nombrepais',
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libro::class, ['pais_cod_pais' => 'cod_pais']);
    }
}
