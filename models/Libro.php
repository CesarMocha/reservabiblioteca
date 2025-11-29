<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libro".
 *
 * @property int $id
 * @property string|null $codigo_barras
 * @property string $titulo
 * @property string $autor
 * @property string|null $isbn
 * @property string|null $cute
 * @property string $editorial
 * @property string|null $anio_publicacion
 * @property string|null $estado
 * @property int|null $n_ejemplares
 * @property string|null $ubicacion
 * @property string $categoria_id
 * @property string $asignatura_id
 * @property string $pais_codigopais
 * @property int $biblioteca_idbiblioteca
 *
 * @property Asignatura $asignatura
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Categoria $categoria
 * @property Pais $paisCodigopais
 * @property Prestamo[] $prestamos
 */
class Libro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'autor', 'editorial', 'categoria_id', 'asignatura_IdAsig', 'pais_cod_pais', 'biblioteca_idbiblioteca'], 'required'],
            [['anio_publicacion'], 'safe'],
            [['n_ejemplares', 'biblioteca_idbiblioteca'], 'integer'],
            [['codigo_barras', 'titulo', 'autor', 'isbn', 'cute', 'editorial', 'ubicacion'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 10],
            [['categoria_id', 'asignatura_IdAsig', 'pais_cod_pais'], 'string', 'max' => 10],
            [['asignatura_IdAsig'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::class, 'targetAttribute' => ['asignatura_IdAsig' => 'IdAsig']],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['pais_cod_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::class, 'targetAttribute' => ['pais_cod_pais' => 'cod_pais']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_barras' => 'Código de Barras',
            'titulo' => 'Título',
            'autor' => 'Autor',
            'isbn' => 'ISBN',
            'cute' => 'CUTE',
            'editorial' => 'Editorial',
            'anio_publicacion' => 'Año de Publicación',
            'estado' => 'Estado',
            'n_ejemplares' => 'N de Ejemplares',
            'ubicacion' => 'Ubicación',
            'categoria_id' => 'Categoría',
            'asignatura_IdAsig' => 'Asignatura',
            'pais_cod_pais' => 'País',
            'biblioteca_idbiblioteca' => 'Biblioteca',
        ];
    }

    /**
     * Gets query for [[Asignatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::class, ['IdAsig' => 'asignatura_IdAsig']);
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
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[PaisCodigopais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaisCodigopais()
    {
        return $this->hasOne(Pais::class, ['cod_pais' => 'pais_cod_pais']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamo::class, ['libro_id' => 'id', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']);
    }
}
