<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "biblioteca".
 *
 * @property int $idbiblioteca
 * @property string $Campus
 * @property string|null $Apertura
 * @property string|null $Cierre
 * @property string|null $Email
 * @property string|null $Telefono
 *
 * @property Libro[] $libros
 * @property Pc[] $pcs
 * @property Prestamo[] $prestamos
 */
class Biblioteca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biblioteca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Campus'], 'required'],
            [['Apertura', 'Cierre'], 'safe'],
            [['Campus', 'Email', 'Telefono'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idbiblioteca' => 'id',
            'Campus' => 'Campus',
            'Apertura' => 'Apertura',
            'Cierre' => 'Cierre',
            'Email' => 'Email',
            'Telefono' => 'Teléfono',
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libro::class, ['biblioteca_idbiblioteca' => 'idbiblioteca']);
    }

    /**
     * Gets query for [[Pcs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPcs()
    {
        return $this->hasMany(Pc::class, ['biblioteca_idbiblioteca' => 'idbiblioteca']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamo::class, ['biblioteca_idbiblioteca' => 'idbiblioteca']);
    }
}
