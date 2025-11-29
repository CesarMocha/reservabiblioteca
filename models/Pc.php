<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pc".
 *
 * @property int $idpc
 * @property string $nombre
 * @property string $estado
 * @property int $biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Prestamo[] $prestamos
 */
class Pc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'estado', 'biblioteca_idbiblioteca'], 'required'],
            [['biblioteca_idbiblioteca'], 'integer'],
            [['nombre'], 'string', 'max' => 15],
            [['estado'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpc' => 'Código de PC',
            'nombre' => 'Nombre',
            'estado' => 'Estado',
            'biblioteca_idbiblioteca' => 'Campus',
        ];
    }

    /**
     * Gets query for [[BibliotecaIdbiblioteca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibliotecaIdbiblioteca()
    {
        return $this->hasOne(Biblioteca::class, ['idbiblioteca' => 'biblioteca_idbiblioteca']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamo::class, ['pc_idpc' => 'idpc', 'pc_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']);
    }
}
