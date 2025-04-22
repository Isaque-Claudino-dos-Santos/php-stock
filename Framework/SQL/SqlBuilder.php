<?php

namespace App\Framework\SQL;

use App\Framework\SQL\Operations\WhereOperation;

class SqlBuilder
{
    private string $select = '*';
    private string $table = '';
    private array $wheres = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private array $orders = [];

    public static function build(): SqlBuilder
    {
        return new self();
    }

    public function select(string ...$values): self
    {
        $this->select = implode(', ', $values);

        if (empty($this->select)) {
            $this->select = '*';
        }

        return $this;
    }

    public function table(string $value): self
    {
        if (class_exists($value)) {
            if (property_exists($value, 'table')) {
                $this->table = $value::$table;
                return $this;
            }
        }

        $this->table = $value;
        return $this;
    }

    public function where(string $key, string $value, string $operator = '='): self
    {
        $this->wheres[] = new WhereOperation($key, $value, $operator, 'AND');
        return $this;
    }

    public function whereAnd(string $key, string $value, string $operator = '='): self
    {
        $this->wheres[] = new WhereOperation($key, $value, $operator, 'AND');
        return $this;
    }

    public function whereOr(string $key, string $value, string $operator = '='): self
    {
        $this->wheres[] = new WhereOperation($key, $value, $operator, 'OR');
        return $this;
    }

    private function buildWheres(): string
    {
        if (empty($this->wheres)) {
            return '';
        }

        $sql = ' WHERE';

        foreach ($this->wheres as $key => $where) {
            if ($key > 0) {
                $sql .= " '{$where->type}'";
            }

            $sql .= " {$where->build()}";
        }

        return $sql;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orders[] = [$column, $direction];
        return $this;
    }

    public function statementUpdate(array $data): string
    {
        $set = [];

        foreach ($data as $key => $value) {
            $set[] = "{$key} = '$value'";
        }

        $set = implode(', ', $set);

        $sql = "UPDATE {$this->table}";
        $sql .= " SET {$set}";
        $sql .= $this->buildWheres();

        return $sql;
    }

    public function statementDelete(): string
    {
        $sql = "DELETE FROM {$this->table}";

        if (empty($this->wheres)) {
            throw new \PDOException('No wheres were found in delete query string');
        }

        $sql .= $this->buildWheres();

        return $sql;
    }

    public function statementCreate(array $data): string
    {
        $keys = implode(', ', array_keys($data));
        $values = implode(', ', array_map(fn($value) => "'$value'", array_values($data)));

        $sql = "INSERT INTO {$this->table} ";
        $sql .= "($keys)";
        $sql .= " VALUES ($values)";

        return $sql;
    }

    public function query(): string
    {
        $sql = "SELECT {$this->select}";
        $sql .= " FROM {$this->table}";

        $sql .= $this->buildWheres();

        if (!empty($this->orders)) {
            $sql .= " ORDER BY";
            $orders = [];

            foreach ($this->orders as $order) {
                $orders[] = "{$order[0]} {$order[1]}";
            }

            $orders = implode(', ', $orders);
            $sql .= " {$orders}";
        }

        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset) {
            $sql .= " OFFSET {$this->offset}";
        }


        return $sql;
    }
}