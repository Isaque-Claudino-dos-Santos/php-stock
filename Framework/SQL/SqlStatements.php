<?php

namespace App\Framework\SQL;

use App\Framework\Model;

class SqlStatements extends SqlBuilder
{
    public function __construct(
        private Model $model,
    )
    {
    }

    /**
     * @template T
     * @param array $data
     * @param T $obj
     * @return T
     */
    private function mergeArrayInObject(array $data, object $obj): Model
    {
        foreach ($data as $key => $value) {
            $key = snakeCaseToCamelCase($key);
            $obj->{$key} = $value;
        }

        return $obj;
    }

    public function all(): array
    {
        $sql = $this->query();
        $data = mysql()->fetch($sql) ?? [];

        $arrayModels = [];

        foreach ($data as $item) {
            $arrayModels[] = $this->mergeArrayInObject($item, new $this->model());
        }

        return $arrayModels;
    }

    public function first(): Model|null
    {
        $sql = $this->limit(1)->query();
        $data = mysql()->fetch($sql)[0] ?? null;

        if (!$data) {
            return null;
        }

        return $this->mergeArrayInObject($data, new $this->model());
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

    /**
     * @template T
     * @param string $model
     * @param string|int $primaryKey
     * @return T
     */
    public function belongToOne(string $model, string|int $primaryKey): Model|null
    {
        $objModel = new $model();
        $this->model = $objModel;

        $table = $objModel->table();
        $primaryKeyColumn = $objModel->primaryKey();

        return $this
            ->table($table)
            ->where($primaryKeyColumn, $primaryKey)
            ->first();
    }

    /**
     * @template T
     * @param T $model
     * @return array<T>
     */
    public function hasMany(string $model, string $foreignKey, string $primaryKey): array
    {
        $objModel = new $model();
        $this->model = $objModel;

        $table = $objModel->table();

        return $this
            ->table($table)
            ->where($foreignKey, $primaryKey)
            ->all();
    }
}