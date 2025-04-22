<?php

namespace App\Framework;

use App\Framework\SQL\SqlStatements;

abstract class Model
{

    abstract public function table(): string;

    public function primaryKey(): string
    {
        return 'id';
    }


    public static function statement(): SqlStatements
    {
        $objModel = new static();
        $statement = new SqlStatements($objModel);
        $statement->table($objModel->table());

        return $statement;
    }
}