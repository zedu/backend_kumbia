<?php

/**
 * ActiveRecord
 *
 * Esta clase es la clase padre de todos los modelos
 * de la aplicacion
 *
 * @category Kumbia
 * @package Db
 * @subpackage ActiveRecord
 */
// Carga el active record
Load::coreLib('kumbia_active_record');

class ActiveRecord extends KumbiaActiveRecord {

//    public $debug = true;
//    public $logger = true;
    
        
    public function activar() {
        $this->activo = '1';
        return $this->update();
    }
    
    public function desactivar() {
        $this->activo = '0';
        return $this->update();
    }

}
