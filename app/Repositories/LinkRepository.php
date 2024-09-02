<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    protected $model;

    public function __construct(Link $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Link $link, array $data)
    {
        return $link->update($data);
    }

    public function delete(Link $link)
    {
        return $link->delete();
    }
}
