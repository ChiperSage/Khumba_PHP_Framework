<?php
// system/db/QueryBuilder.php

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $select = '*';
    protected $where = [];
    protected $bindings = [];
    protected $limit;
    protected $offset;
    protected $orderBy;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($fields = '*')
    {
        $this->select = $fields;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "$column $direction";
        return $this;
    }

    public function limit($limit, $offset = null)
    {
        $this->limit = (int)$limit;
        $this->offset = $offset !== null ? (int)$offset : null;
        return $this;
    }

    public function get()
    {
        $sql = $this->buildSelect();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->limit(1);
        $result = $this->get();
        return isset($result[0]) ? $result[0] : null;
    }

    public function insert(array $data)
    {
        $columns = array_keys($data);
        $values = array_values($data);

        $placeholders = implode(',', array_fill(0, count($columns), '?'));

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($values);
    }

    public function update(array $data)
    {
        $set = [];
        $values = [];

        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
            $values[] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $set);

        if ($this->where) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
            $values = array_merge($values, $this->bindings);
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->table}";

        if ($this->where) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }

    protected function buildSelect()
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if ($this->where) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
            if ($this->offset !== null) {
                $sql .= " OFFSET {$this->offset}";
            }
        }

        return $sql;
    }
}
