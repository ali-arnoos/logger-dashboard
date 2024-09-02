<?php

namespace App\Repositories;

use App\Models\ChangeHistory;

class ChangeHistoryRepository
{
    protected $model;

    public function __construct(ChangeHistory $model)
    {
        $this->model = $model;
    }

    public function getByLinkId($linkId)
    {
        return $this->model->where('link_id', $linkId)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
