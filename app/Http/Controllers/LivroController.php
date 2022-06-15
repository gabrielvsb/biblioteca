<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\LivroService;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    protected $livroService;

    /**
     * LivroController constructor.
     * @param LivroService $livroService
     */
    public function __construct(LivroService $livroService)
    {
        $this->livroService = $livroService;
    }


    public function index()
    {
        $livros = $this->livroService->todosRegistros();
        return view('livro.index', ['livros' => $livros]);

    }

    public function store(Request $request)
    {
        $this->livroService->cadastrar($request);
        return redirect()->route('livro.index');
    }

    public function show(int $id)
    {
        $livro = $this->livroService->detalhes($id);
        return view('detalhes', ['livro' => $livro]);
    }

    public function update(Request $request, int $id)
    {
        $this->livroService->editar($id, $request);
        return redirect()->route('livro.index');
    }

    public function destroy(int $id)
    {
        $this->livroService->deletar($id);
        return redirect()->route('livro.index');
    }
}
