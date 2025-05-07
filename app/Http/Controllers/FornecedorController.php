<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Fornecedor::query();

        // Filtro por CPF ou CNPJ
        if ($request->has('documento')) {
            $query->where('documento', $request->input('documento'));
        }

        // Ordenação
        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), $request->input('order', 'asc'));
        }

        // Paginação
        return response()->json($query->paginate(10));
    }

    public function store(StoreFornecedorRequest $request)
    {
        $fornecedor = Fornecedor::create($request->validated());
        return response()->json($fornecedor, 201);
    }

    public function show($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return response()->json($fornecedor);
    }

    public function update(StoreFornecedorRequest $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update($request->validated());
        return response()->json($fornecedor);
    }

    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();
        return response()->json(['message' => 'Fornecedor removido com sucesso.']);
    }

    public function buscaCnpj($cnpj)
    {
        // Remove qualquer caractere não numérico
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Valida o CNPJ (pode ser uma validação extra aqui)
        if (!$this->validaCnpj($cnpj)) {
            return response()->json(['message' => 'CNPJ inválido'], 400);
        }

        // Chama a BrasilAPI para buscar o CNPJ
        $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

        // Verifica se a resposta é válida
        if ($response->failed()) {
            return response()->json(['message' => 'Erro ao consultar o CNPJ'], 500);
        }

        // Retorna os dados do CNPJ
        return response()->json($response->json());
    }

    private function validaCnpj($cnpj): bool
    {
        // A lógica de validação do CNPJ já foi explicada na etapa de validação do documento
        // (Você pode reutilizar a função validaCnpj que já criamos)
        return (new \App\Rules\CpfCnpj)->validaCnpj($cnpj);
    }
}
