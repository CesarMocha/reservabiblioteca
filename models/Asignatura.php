<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignatura".
 *
 * @property string $idAsig
 * @property string $NombreAsig
 *
 * @property Libro[] $libros
 */
class Asignatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdAsig', 'NombAsig'], 'required'],
            [['IdAsig'], 'string', 'max' => 4],
            [['NombAsig'], 'string', 'max' => 60],
            [['IdAsig'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAsig' => 'ID',
            'NombAsig' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libro::class, ['asignatura_IdAsig' => 'IdAsig']);
    }
}
