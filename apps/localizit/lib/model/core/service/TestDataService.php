<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2011 Orange-localizit Inc., http://www.orange-localizit.com
 *
 * Orange-localizit is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * Orange-localizit is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */


class TestDataService {

    private static $dbConnection;
    private static $data;
    private static $tableNames;

    public static function populate($fixture) {

        self::_setData($fixture);

        self::_disableConstraints();

        self::_truncateTables();

        foreach (self::$data as $tableName => $tableData) {

            $count = 0;

            foreach ($tableData as $key => $dataRow) {

                $rowObject = new $tableName;
                $rowObject->fromArray($dataRow);

                // hashing password
                if ($dataRow['password'] != '') {
                    $rowObject['password'] = md5($dataRow['password']);
                }

                $rowObject->save();

                $count++;
            }

            if ($count > 0) {
                self::adjustUniqueId($tableName, $count, true);
            }
        }

        self::_enableConstraints();
    }

    public static function adjustUniqueId($tableName, $count, $isAlias = false) {

        /*
         * not needed
         */
    }

    private static function _setData($fixture) {

        self::$data = sfYaml::load($fixture);
        self::_setTableNames();
    }

    private static function _setTableNames() {

        foreach (self::$data as $key => $value) {
            self::$tableNames[] = Doctrine::getTable($key)->getTableName();
        }
    }

    private static function _disableConstraints() {

        // ToDo: disable database constraints
        $db = self::_getDbConnection();
        $db->query("SET FOREIGN_KEY_CHECKS = 0");
    }

    private static function _enableConstraints() {

        // ToDo: enable database constraints
    }

    private static function _truncateTables() {

        $db = self::_getDbConnection();

        self::_disableConstraints();

        foreach (self::$tableNames as $tableName) {
            $db->query("TRUNCATE TABLE $tableName");
            self::adjustUniqueId($tableName, 0);
        }

        self::_enableConstraints();
    }

    private static function _getDbConnection() {

        if (empty(self::$dbConnection)) {

            self::$dbConnection = Doctrine_Manager::getInstance()
                            ->getCurrentConnection()
                            ->getDbh();

            return self::$dbConnection;
        } else {

            return self::$dbConnection;
        }
    }
}