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
 * @package Helper
 * @license http://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE version 3.
 * @author Manuel José Aguirre Garcia <programador.manuel@gmail.com>
 */
Load::models('menus');

class Menu {

    /**
     * Id del rol del usuario logueado actualmente
     *
     * @var int 
     */
    protected static $_id_rol = NULL;

    public static function render($id_rol) {
        self::$_id_rol = $id_rol;
        $rL = new Menus();
        $registros = $rL->obtener_menu_por_rol($id_rol);
        $html = '';
        if ($registros) {
            $html .= '<ul class="nav" data-dropdown="dropdown">' . PHP_EOL;
            foreach ($registros as $e) {
                $html .= self::generarItems($e);
            }
            $html .= '</ul>' . PHP_EOL;
        }
        return $html;
    }

    protected static function generarItems($objeto_menu) {
        $sub_menu = $objeto_menu->get_sub_menus(self::$_id_rol);
        $class = 'menu_' . str_replace('/', '_', $objeto_menu->url);
        if ($sub_menu) {
            $html = "<li class='{$class} dropdown {$objeto_menu->clases}'>" .
                    Html::link($objeto_menu->url, $objeto_menu->nombre ,'class="dropdown-toggle"') . PHP_EOL;
                    //"<a href='#' class='dropdown-toggle'>$objeto_menu->nombre</a>" . PHP_EOL;
        } else {
            $html = "<li class='{$class} {$objeto_menu->clases}'>" .
                    Html::link($objeto_menu->url, $objeto_menu->nombre) . PHP_EOL;
        }
        if ($sub_menu) {
            $html .= '<ul class="dropdown-menu">' . PHP_EOL;
            foreach ($sub_menu as $e) {
                $html .= self::generarItems($e);
            }
            $html .= '</ul>' . PHP_EOL;
        }
        return $html . "</li>" . PHP_EOL;
    }

    protected static function es_activa($url) {
        $url_actual = substr(Router::get('route'), 1);
        return (strpos($url, $url_actual) !== false || strpos($url, "$url_actual/index") !== false);
    }

}