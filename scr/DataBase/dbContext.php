<?php
require_once 'SQL_Constants.php';

class dbContext
{

    public static function initDataBase($pdo, $models)
    {
        $query = '';
        if (!is_array($models)) {
            throw new Exception('Incorrect list of models');
        }
        foreach ($models as $index => $model) {
            $query = $query . 'CREATE TABLE IF NOT EXISTS ' . $model->getModelName() . '(';

            $attributeList = $model->getAttributes();
            foreach ($attributeList as $key => $column) {
                if (!array_key_exists('title', $column) || !array_key_exists('type', $column)) {
                    throw new Exception("Required params were not provided in " . $model->getModelName());
                }

                preg_match('/^[a-zA-Z_]+\b/', $column['type'], $matches);
                $baseType = $matches[0] ?? null;

                if (!$baseType && !in_array($column['type'], SQL_DATA_TYPES)) {
                    throw new Exception("Wrong data type in " . $model->getModelName() . " where column name is " . $column['title']);
                }

                $query .= "{$column['title']} {$column['type']}";

                foreach ($column as $attribute => $value) {
                    if ($attribute !== 'title' && $attribute !== 'type' && in_array($attribute, SQL_TABLE_DEF_ATTRS)) {
                        switch ($attribute) {
                            case "primaryKey":
                                if (is_bool($column["primaryKey"]) && $column["primaryKey"]) {
                                    $query .= " PRIMARY KEY";
                                } else if (!is_bool(($column["primaryKey"]))) {
                                    throw new Exception('primaryKey attribute must be a boolean');
                                }
                                break;
                            case "autoIncrement":
                                if (is_bool($column["autoIncrement"]) && $column["autoIncrement"]) {
                                    $query .= " GENERATED ALWAYS AS IDENTITY";
                                } else if (!is_bool(($column["autoIncrement"]))) {
                                    throw new Exception('autoIncrement attribute must be a boolean');
                                }
                                break;
                            case "allowNull":
                                if (is_bool($column["allowNull"]) && !$column["allowNull"]) {
                                    $query .= " NOT NULL";
                                } else if (!is_bool(($column["allowNull"]))) {
                                    throw new Exception('allowNull attribute must be a boolean');
                                }
                                break;
                            case "unique":
                                if (is_bool($column["unique"]) && $column["unique"]) {
                                    $query .= " UNIQUE";
                                } else if (!is_bool(($column["unique"]))) {
                                    throw new Exception('unique attribute must be a boolean');
                                }
                                break;
                            case "defaultValue":
                                if (!is_array($column["defaultValue"])) {
                                    $query .= "{$column['defaultValue']} ";
                                } else if (is_array($column["defaultValue"])) {
                                    throw new Exception('defaultValue attribute cannot be an array');
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
                if ($key !== sizeof($attributeList) - 1) {
                    $query .= ',';
                }
            }
            if ($index !== sizeof($models) - 1) {
                $query .= '), ';
            } else {
                $query .= '); ';
            }
        }

        $pdo->exec($query);
    }
}