<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

class HashModel
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getHash(): string
    {
        $fields = [];
        foreach ($this->model->fieldsForHash as $field) {
            $fields[$field] = $this->model->{$field};
        }
        return hash('sha256', json_encode($fields));
    }
}
