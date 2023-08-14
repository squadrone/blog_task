<?php

namespace Project\Services;

trait QueryBuilder
{
    public string $tableName;

    public function insertQuery(array $fields): string {
        if (count($fields) == 0) {
            throw new \Exception('Invalid arguments for '.__METHOD__);
        }
        $fieldsString = implode(', ', $fields);
        $values = [];
        foreach ($fields as $field) {
            $values[] = "{$field} = :{$field}";
        }
        $valuesString = implode(', ', $values);
        return "INSERT INTO {$this->tableName} ({$fieldsString}) VALUES ({$valuesString});";
    }

    public function updateQuery(array $fields, array $keys): string {
        if (count($fields) == 0 || count($keys) == 0) {
            throw new \Exception('Invalid arguments for '.__METHOD__);
        }
        $values = [];
        foreach ($fields as $field) {
            $values[] = "{$field} = :{$field}";
        }
        $keyValues = [];
        foreach ($keys as $key) {
            $keyValues[] = "{$key} = :{$key}";
        }
        $valuesString = implode(', ', $values);
        $whereString = implode(' AND ', $keyValues);
        return "UPDATE {$this->tableName} SET ({$valuesString}) VALUES ({$whereString});";
    }
}