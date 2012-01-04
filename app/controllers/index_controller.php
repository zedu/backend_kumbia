<?php
/**
* Backend - KumbiaPHP Backend
* PHP version 5
* LICENSE
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as
* published by the Free Software Foundation, either version 3 of the
* License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* ERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program. If not, see <http://www.gnu.org/licenses/>.
*
* @package Controller
* @license http://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE version 3.
* @author Manuel José Aguirre Garcia <programador.manuel@gmail.com>
*/
class IndexController extends AppController {

    public function after_filter() {
        if (MyAuth::es_valido()) {
            Router::redirect('admin/usuarios');
        }
    }

    public function index() {
        try {
            View::template('default');

            $usuario = Load::model('usuarios');

            if (Input::hasPost('login') && Input::hasPost('clave')) {
                if (MyAuth::autenticar(Input::post('login'), Input::post('clave'))) {
                    return Router::redirect('admin/usuarios');
                } else {
                    Flash::warning('Datos de Acceso invalidos');
                }
            }
        } catch (KumbiaException $e) {
            View::excepcion($e);
        }
    }

    public function logout() {
        MyAuth::cerrar_sesion();
        return Router::redirect();
    }

}
