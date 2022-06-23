<?php
declare(strict_types=1);

namespace App\Repositories;


class BaseRepository
{
    private object $obj;

    public function __construct(object $obj)
    {
        $this->obj = $obj;
    }

    public function all(): object
    {
        return $this->obj->all();
    }

    public function find(int $id): object|null
    {
        return $this->obj->find($id);
    }

    public function save(array $atributos): object
    {
        return $this->obj->create($atributos);
    }

    public function update(int $id, array $atributos): bool
    {
        return $this->obj->find($id)->update($atributos);
    }

    public function delete(int $id): bool
    {
        return $this->obj->find($id)->delete();
    }
}
