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
 * @package Libs
 * @license http://www.gnu.org/licenses/agpl.txt GNU AFFERO GENERAL PUBLIC LICENSE version 3.
 * @author Manuel José Aguirre Garcia <programador.manuel@gmail.com>
 */
class LectorRecursos {

    public static $_controladores;
    public static $_recursos;

    public static function obtenerRecursos() {
        self::escanearDir();
        self::escanearControladores();
        var_dump(self::$_controladores);
    }

    protected static function escanearDir($modulo = NUll) {
        $dir = APP_PATH . 'controllers' . ( $modulo ? "/$modulo" : '' );
        $res = scandir($dir);
        $modulos = array();
        foreach ($res as $e) {
            if (strpos($e, '_controller.php')) {
                self::$_controladores[] = array(
                    'dir' => "$dir/$e",
                    'class' => str_replace('.php', '', $e),
                    'modulo' => $modulo
                );
            } elseif ($e !== '.' && $e !== '..') {
                $modulos[] = $e;
            }
        }
        foreach ($modulos as $mod) {
            self::escanearDir($mod);
        }
    }

    protected static function escanearControladores() {
        foreach (self::$_controladores as $e) {
            if (!class_exists($e['class']))
                require_once $e['dir'];
            if ($metodos = get_class_methods($e['class'])) {
                foreach ($metodos as $metodo) {
                    if ($metodo !== '__contruct' && $metodo !== '_callback') {
                        //self::$_recursos[] =
                    }
                }
            }
        }
    }

}

