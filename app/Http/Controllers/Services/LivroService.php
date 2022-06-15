<?php


namespace App\Http\Controllers\Services;


use App\Http\Controllers\Repositories\LivroRepository;
use Illuminate\Http\Request;

class LivroService
{
    protected $livroRepository;

    /**
     * LivroService constructor.
     * @param LivroRepository $livroRepository
     */
    public function __construct(LivroRepository $livroRepository)
    {
        $this->livroRepository = $livroRepository;
    }

    public function cadastrar(Request $request)
    {
        $validate = $request->all();
        $this->livroRepository->save($validate);
    }

    public function todosRegistros()
    {
        return $this->livroRepository->all();
    }

    public function detalhes(int $id): object
    {
        return $this->livroRepository->find($id);
    }

    public function editar(int $id, Request $request): bool
    {
        $validate = $request->all();
        return $this->livroRepository->update($id, $validate);
    }

    public function deletar(int $id): bool
    {
        return $this->livroRepository->delete($id);
    }
}
