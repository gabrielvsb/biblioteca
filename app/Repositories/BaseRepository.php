<?php
declare(strict_types=1);

namespace App\Repositories;


class BaseRepository
{
    private object $model;

    public function __construct(object $model)
    {
        $this->model = $model;
    }

    public function all(): object
    {
        return $this->model->all();
    }

    public function find(int $id): object|null
    {
        return $this->model->find($id);
    }

    public function save(array $atributos): object
    {
        return $this->model->create($atributos);
    }

    public function update(int $id, array $atributos): bool
    {
        $model = $this->model->find($id);
        if(!$model){
            return false;
        }
        return $model->update($atributos);
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if(!$model){
            return false;
        }
        return $model->delete();
    }
}
