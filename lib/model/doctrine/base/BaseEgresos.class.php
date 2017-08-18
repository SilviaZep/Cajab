<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Egresos', 'default');

/**
 * BaseEgresos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $id_servicio
 * @property integer $id_proveedor
 * @property integer $id_concepto
 * @property date $fecha_registro
 * @property integer $tipo_pago
 * @property string $referencia
 * @property float $cantidad
 * @property string $observaciones
 * @property integer $estatus
 * 
 * @method integer getId()             Returns the current record's "id" value
 * @method integer getIdServicio()     Returns the current record's "id_servicio" value
 * @method integer getIdProveedor()    Returns the current record's "id_proveedor" value
 * @method integer getIdConcepto()     Returns the current record's "id_concepto" value
 * @method date    getFechaRegistro()  Returns the current record's "fecha_registro" value
 * @method integer getTipoPago()       Returns the current record's "tipo_pago" value
 * @method string  getReferencia()     Returns the current record's "referencia" value
 * @method float   getCantidad()       Returns the current record's "cantidad" value
 * @method string  getObservaciones()  Returns the current record's "observaciones" value
 * @method integer getEstatus()        Returns the current record's "estatus" value
 * @method Egresos setId()             Sets the current record's "id" value
 * @method Egresos setIdServicio()     Sets the current record's "id_servicio" value
 * @method Egresos setIdProveedor()    Sets the current record's "id_proveedor" value
 * @method Egresos setIdConcepto()     Sets the current record's "id_concepto" value
 * @method Egresos setFechaRegistro()  Sets the current record's "fecha_registro" value
 * @method Egresos setTipoPago()       Sets the current record's "tipo_pago" value
 * @method Egresos setReferencia()     Sets the current record's "referencia" value
 * @method Egresos setCantidad()       Sets the current record's "cantidad" value
 * @method Egresos setObservaciones()  Sets the current record's "observaciones" value
 * @method Egresos setEstatus()        Sets the current record's "estatus" value
 * 
 * @package    puntoveta
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEgresos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('egresos');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('id_servicio', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('id_proveedor', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('id_concepto', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('fecha_registro', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('tipo_pago', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('referencia', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 45,
             ));
        $this->hasColumn('cantidad', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('observaciones', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('estatus', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}