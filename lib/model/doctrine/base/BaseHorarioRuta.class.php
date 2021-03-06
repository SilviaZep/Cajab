<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('HorarioRuta', 'default');

/**
 * BaseHorarioRuta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $r_lun_e
 * @property integer $r_lun_s
 * @property integer $r_mar_e
 * @property integer $r_mar_s
 * @property integer $r_mie_e
 * @property integer $r_mie_s
 * @property integer $r_jue_e
 * @property integer $r_jue_s
 * @property integer $r_vie_e
 * @property integer $r_vie_s
 * @property timestamp $fecha_registro
 * @property integer $usuario_registro
 * @property integer $tipo
 * @property integer $id_alumno
 * 
 * @method integer     getId()               Returns the current record's "id" value
 * @method integer     getRLunE()            Returns the current record's "r_lun_e" value
 * @method integer     getRLunS()            Returns the current record's "r_lun_s" value
 * @method integer     getRMarE()            Returns the current record's "r_mar_e" value
 * @method integer     getRMarS()            Returns the current record's "r_mar_s" value
 * @method integer     getRMieE()            Returns the current record's "r_mie_e" value
 * @method integer     getRMieS()            Returns the current record's "r_mie_s" value
 * @method integer     getRJueE()            Returns the current record's "r_jue_e" value
 * @method integer     getRJueS()            Returns the current record's "r_jue_s" value
 * @method integer     getRVieE()            Returns the current record's "r_vie_e" value
 * @method integer     getRVieS()            Returns the current record's "r_vie_s" value
 * @method timestamp   getFechaRegistro()    Returns the current record's "fecha_registro" value
 * @method integer     getUsuarioRegistro()  Returns the current record's "usuario_registro" value
 * @method integer     getTipo()             Returns the current record's "tipo" value
 * @method integer     getIdAlumno()         Returns the current record's "id_alumno" value
 * @method HorarioRuta setId()               Sets the current record's "id" value
 * @method HorarioRuta setRLunE()            Sets the current record's "r_lun_e" value
 * @method HorarioRuta setRLunS()            Sets the current record's "r_lun_s" value
 * @method HorarioRuta setRMarE()            Sets the current record's "r_mar_e" value
 * @method HorarioRuta setRMarS()            Sets the current record's "r_mar_s" value
 * @method HorarioRuta setRMieE()            Sets the current record's "r_mie_e" value
 * @method HorarioRuta setRMieS()            Sets the current record's "r_mie_s" value
 * @method HorarioRuta setRJueE()            Sets the current record's "r_jue_e" value
 * @method HorarioRuta setRJueS()            Sets the current record's "r_jue_s" value
 * @method HorarioRuta setRVieE()            Sets the current record's "r_vie_e" value
 * @method HorarioRuta setRVieS()            Sets the current record's "r_vie_s" value
 * @method HorarioRuta setFechaRegistro()    Sets the current record's "fecha_registro" value
 * @method HorarioRuta setUsuarioRegistro()  Sets the current record's "usuario_registro" value
 * @method HorarioRuta setTipo()             Sets the current record's "tipo" value
 * @method HorarioRuta setIdAlumno()         Sets the current record's "id_alumno" value
 * 
 * @package    puntoveta
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHorarioRuta extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('horario_ruta');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('r_lun_e', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_lun_s', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_mar_e', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_mar_s', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_mie_e', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_mie_s', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_jue_e', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_jue_s', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_vie_e', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('r_vie_s', 'integer', 4, array(
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
        $this->hasColumn('usuario_registro', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('tipo', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('id_alumno', 'integer', 4, array(
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