<?php

/**
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 * */
// @see Controller nuevo controller
require_once CORE_PATH . 'kumbia/controller.php';

class AppController extends Controller {

    final protected function initialize() {
        if (MyAuth::es_valido()) {
            $acl = new MyAcl();
            if (!$acl->check()) {
                if ($acl->limiteDeIntentosPasado()) {
                    $acl->resetearIntentos();
                    return $this->intentos_pasados();
                }
                Flash::error('no posees privilegios para acceder a <b>' . Router::get('route') . '</b>');
                View::select(NULL, 'informacion');
                return false;
            } else {
                $acl->resetearIntentos();
            }
            if ($this->module_name == 'admin') {
                View::template('backend');
            }
        } else {
            if ($this->controller_name != 'index') {
                Flash::warning("Debes iniciar sesión");
                Router::redirect('/');
            }
        }
    }

    final protected function finalize() {
        
    }

    protected function intentos_pasados() {
        MyAuth::cerrar_sesion();
        Flash::warning('Has Sobrepasado el limite de intentos fallidos al tratar acceder a ciertas partes del sistema');
        return Router::redirect('/');
    }

}