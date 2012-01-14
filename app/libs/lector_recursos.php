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

    public static $_recursos;

    public static function obtenerRecursos() {
        self::escanearDir();
        self::escanearControladores();
        var_dump(self::$_recursos);
    }

    protected static function escanearDir($dir = NUll) {
        $dir = $dir ? $dir : APP_PATH . 'controllers';
        $res = scandir($dir);
        $modulos = array();
        foreach ($res as $e) {
            if (strpos($e, '_controller.php')) {
                self::$_recursos[] = array(
                    'dir' => "$dir/$e",
                    'class' => Util::camelcase(str_replace('.php', '', $e)),
                );
            } elseif ($e !== '.' && $e !== '..') {
                $modulos[] = $e;
            }
        }
        foreach ($modulos as $mod) {
            self::escanearDir("$dir/$mod");
        }
    }

    protected static function escanearControladores() {
        foreach (self::$_recursos as $e) {
            if (!class_exists($e['class']))
                require_once $e['dir']; 
            var_dump($e['dir'],get_class_methods($e['class']));
        }
    }

}

