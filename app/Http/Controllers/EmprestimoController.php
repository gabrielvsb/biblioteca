<?php

namespace App\Http\Controllers;

use App\Services\EmprestimoService;
use Illuminate\Http\Request;

class EmprestimoController extends Controller
{
    protected $emprestimoService;

    /**
     * EmprestimoController constructor.
     * @param EmprestimoService $emprestimoService
     */
    public function __construct(EmprestimoService $emprestimoService)
    {
        $this->emprestimoService = $emprestimoService;
    }


    public function index()
    {
        $emprestimos = $this->emprestimoService->todosRegistros();
        return view('emprestimo.index', ['emprestimos' => $emprestimos]);
    }

    public function store(Request $request)
    {
        $this->emprestimoService->cadastrar($request);
        return redirect()->route('emprestimo.index');
    }

    public function show(int $id)
    {
        $emprestimo = $this->emprestimoService->detalhes($id);
        return view('detalhes', ['emprestimo' => $emprestimo]);
    }

    public function update(Request $request, int $id)
    {
        $this->emprestimoService->editar($id, $request);
        return redirect()->route('emprestimo.index');
    }

    public function destroy(int $id)
    {
        $this->emprestimoService->deletar($id);
        return redirect()->route('emprestimo.index');
    }
}
