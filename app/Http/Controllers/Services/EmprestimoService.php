<?php


namespace App\Http\Controllers\Services;


use App\Http\Controllers\Repositories\EmprestimoRepository;
use Illuminate\Http\Request;

class EmprestimoService
{
    protected $emprestimoRepository;

    /**
     * EmprestimoService constructor.
     * @param EmprestimoRepository $emprestimoRepository
     */
    public function __construct(EmprestimoRepository $emprestimoRepository)
    {
        $this->emprestimoRepository = $emprestimoRepository;
    }

    public function cadastrar(Request $request)
    {
        $validate = $request->all();
        $this->emprestimoRepository->save($validate);
    }

    public function todosRegistros()
    {
        return $this->emprestimoRepository->all();
    }

    public function detalhes(int $id): object
    {
        return $this->emprestimoRepository->find($id);
    }

    public function editar(int $id, Request $request): bool
    {
        $validate = $request->all();
        return $this->emprestimoRepository->update($id, $validate);
    }

    public function deletar(int $id): bool
    {
        return $this->emprestimoRepository->delete($id);
    }
}
