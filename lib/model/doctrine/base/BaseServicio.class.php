<?php

// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Servicio', 'default');

/**
 * BaseServicio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $id_servicio
 * @property string $nombre
 * @property integer $aplica_parcialidad
 * @property float $precio
 * @property integer $pago_obligatorio
 * @property date $fecha_evento
 * @property integer $capacidad
 * @property timestamp $fecha_inicio
 * @property timestamp $fecha_fin
 * @property integer $usuario_registro
 * @property timestamp $fecha_registro
 * @property integer $activo
 * @property integer $tipo_cliente
 * @property integer $tipo_transporte
 * 
 * @method integer   getId()                 Returns the current record's "id" value
 * @method integer   getIdServicio()         Returns the current record's "id_servicio" value
 * @method string    getNombre()             Returns the current record's "nombre" value
 * @method integer   getAplicaParcialidad()  Returns the current record's "aplica_parcialidad" value
 * @method float     getPrecio()             Returns the current record's "precio" value
 * @method integer   getPagoObligatorio()    Returns the current record's "pago_obligatorio" value
 * @method date      getFechaEvento()        Returns the current record's "fecha_evento" value
 * @method integer   getCapacidad()          Returns the current record's "capacidad" value
 * @method timestamp getFechaInicio()        Returns the current record's "fecha_inicio" value
 * @method timestamp getFechaFin()           Returns the current record's "fecha_fin" value
 * @method integer   getUsuarioRegistro()    Returns the current record's "usuario_registro" value
 * @method timestamp getFechaRegistro()      Returns the current record's "fecha_registro" value
 * @method integer   getActivo()             Returns the current record's "activo" value
 * @method integer   getTipoCliente()        Returns the current record's "tipo_cliente" value
 * @method integer   getTipoTransporte()     Returns the current record's "tipo_transporte" value
 * @method Servicio  setId()                 Sets the current record's "id" value
 * @method Servicio  setIdServicio()         Sets the current record's "id_servicio" value
 * @method Servicio  setNombre()             Sets the current record's "nombre" value
 * @method Servicio  setAplicaParcialidad()  Sets the current record's "aplica_parcialidad" value
 * @method Servicio  setPrecio()             Sets the current record's "precio" value
 * @method Servicio  setPagoObligatorio()    Sets the current record's "pago_obligatorio" value
 * @method Servicio  setFechaEvento()        Sets the current record's "fecha_evento" value
 * @method Servicio  setCapacidad()          Sets the current record's "capacidad" value
 * @method Servicio  setFechaInicio()        Sets the current record's "fecha_inicio" value
 * @method Servicio  setFechaFin()           Sets the current record's "fecha_fin" value
 * @method Servicio  setUsuarioRegistro()    Sets the current record's "usuario_registro" value
 * @method Servicio  setFechaRegistro()      Sets the current record's "fecha_registro" value
 * @method Servicio  setActivo()             Sets the current record's "activo" value
 * @method Servicio  setTipoCliente()        Sets the current record's "tipo_cliente" value
 * @method Servicio  setTipoTransporte()     Sets the current record's "tipo_transporte" value
 * 
 * @package    puntoveta
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseServicio extends sfDoctrineRecord {

    public function setTableDefinition() {
        $this->setTableName('servicio');
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
        $this->hasColumn('nombre', 'string', 200, array(
            'type' => 'string',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 200,
        ));
        $this->hasColumn('aplica_parcialidad', 'integer', 2, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 2,
        ));
        $this->hasColumn('precio', 'float', null, array(
            'type' => 'float',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => '',
        ));
        $this->hasColumn('pago_obligatorio', 'integer', 2, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 2,
        ));
        $this->hasColumn('fecha_evento', 'date', 25, array(
            'type' => 'date',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 25,
        ));
        $this->hasColumn('capacidad', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('fecha_inicio', 'timestamp', 25, array(
            'type' => 'timestamp',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 25,
        ));
        $this->hasColumn('fecha_fin', 'timestamp', 25, array(
            'type' => 'timestamp',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 25,
        ));
        $this->hasColumn('usuario_registro', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('fecha_registro', 'timestamp', 25, array(
            'type' => 'timestamp',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 25,
        ));
        $this->hasColumn('activo', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('tipo_cliente', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('tipo_transporte', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('categoria_id', 'integer', 4, array(
            'type' => 'integer',
            'fixed' => 0,
            'unsigned' => false,
            'primary' => false,
            'notnull' => false,
            'autoincrement' => false,
            'length' => 4,
        ));
        $this->hasColumn('ciclo_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
          $this->hasColumn('grado_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
           $this->hasColumn('grupo_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp() {
        parent::setUp();
    }

}
