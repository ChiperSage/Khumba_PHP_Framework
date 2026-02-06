<?php
// system/core/Model.php

class Model
{
    protected $table;

    public function db()
    {
        return Database::table($this->table);
    }

    public function all()
    {
        return $this->db()->get();
    }

    public function find($id)
    {
        return $this->db()->where('id', '=', $id)->first();
    }

    public function create($data)
    {
        return $this->db()->insert($data);
    }

    public function updateWhere($id, $data)
    {
        return $this->db()->where('id', '=', $id)->update($data);
    }

    public function deleteWhere($id)
    {
        return $this->db()->where('id', '=', $id)->delete();
    }
}
