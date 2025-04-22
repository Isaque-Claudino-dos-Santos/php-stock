<?php

namespace App\Framework\SQL;

use App\Framework\Model;

class SqlStatements extends SqlBuilder
{
    public function __construct(
        private readonly Model $model,
    )
    {
    }

    public function all(): array
    {
        $sql = $this->query();
        $data = mysql()->fetch($sql);

        return $data ?? [];
    }

    public function first(): array|null
    {
        $sql = $this->limit(1)->query();
        $data = mysql()->fetch($sql);

        return $data[0] ?? null;
    }

    public function update(array $data): void
    {
        $sql = $this->statementUpdate($data);
        mysql()->exec($sql);
    }

    public function create(array $data): void
    {
        $sql = $this->statementCreate($data);
        mysql()->exec($sql);
    }

    public function delete(): void
    {
        $sql = $this->statementDelete();
        mysql()->exec($sql);
    }

    public function count(): int
    {
        $primaryKey = $this->model->primaryKey();
        $sql = $this->select("count($primaryKey) as count")->query();
        $data = mysql()->fetch($sql);

        return $data[0]['count'] ?? 0;
    }


    public function paginate(int $page = 1, int $limit = 30): SqlPagination
    {
        $offset = $limit * ($page - 1);

        $sql = $this->limit($limit)->offset($offset)->query();

        $data = mysql()->fetch($sql) ?? [];
        $totalPages = intval(ceil($this->count() / $limit));

        return new SqlPagination(
            items: $data,
            limit: $limit,
            page: $page,
            totalItems: count($data),
            totalPages: $totalPages,
            hasNextPage: $page < $totalPages,
            hasPreviousPage: $page > 1,
        );
    }
}