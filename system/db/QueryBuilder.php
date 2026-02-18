<?php
class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $wheres = [];
    protected $bindings = [];
    protected $limit;
    protected $order;

    public function __construct($pdo, $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function where($column, $value, $operator = '=')
    {
        $this->wheres[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->order = "ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = "LIMIT " . intval($limit);
        return $this;
    }

    protected function buildSelect()
    {
        $sql = "SELECT * FROM {$this->table}";

        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }

        if ($this->order) {
            $sql .= " " . $this->order;
        }

        if ($this->limit) {
            $sql .= " " . $this->limit;
        }

        return $sql;
    }

    public function get()
    {
        $stmt = $this->pdo->prepare($this->buildSelect());
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->limit(1);
        $result = $this->get();
        return $result ? $result[0] : null;
    }

    public function insert($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function update($data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $this->bindings[] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(',', $fields);

        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->table}";

        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bindings);
    }
}
