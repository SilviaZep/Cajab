<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Pagos', 'default');

/**
 * BasePagos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $id_servicio
 * @property integer $id_cliente
 * @property float $abono
 * @property timestamp $fecha_pago
 * 
 * @method integer   getId()          Returns the current record's "id" value
 * @method integer   getIdServicio()  Returns the current record's "id_servicio" value
 * @method integer   getIdCliente()   Returns the current record's "id_cliente" value
 * @method float     getAbono()       Returns the current record's "abono" value
 * @method timestamp getFechaPago()   Returns the current record's "fecha_pago" value
 * @method Pagos     setId()          Sets the current record's "id" value
 * @method Pagos     setIdServicio()  Sets the current record's "id_servicio" value
 * @method Pagos     setIdCliente()   Sets the current record's "id_cliente" value
 * @method Pagos     setAbono()       Sets the current record's "abono" value
 * @method Pagos     setFechaPago()   Sets the current record's "fecha_pago" value
 * 
 * @package    puntoveta
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePagos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('pagos');
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
        $this->hasColumn('id_cliente', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('abono', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('fecha_pago', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}