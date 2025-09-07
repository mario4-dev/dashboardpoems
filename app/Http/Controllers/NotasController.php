<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Notas;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Notas::orderByDesc('created_at')->get(['id','title','content','created_at']);
        return Inertia::render('Notas/Index', [
            'notas' => $notas->map(fn ($n) => [
                'id' => $n->id,
                'title' => $n->title,
                'content' => $n->content,
                'created_at' => $n->created_at?->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return Inertia::render('Notas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:150'],
            'content' => ['required','string'],
        ]);

        $nota = Notas::create($data);
        return redirect()->route('notas.show', $nota->id)->with('success','Nota creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notas $nota)
    {
        return Inertia::render('Notas/Show', [
            'nota' => [
                'id' => $nota->id,
                'title' => $nota->title,
                'content' => $nota->content,
                'created_at' => $nota->created_at?->toDateTimeString(),
                'updated_at' => $nota->updated_at?->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notas $nota)
    {
        return Inertia::render('Notas/Edit', [
            'nota' => [
                'id' => $nota->id,
                'title' => $nota->title,
                'content' => $nota->content,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notas $nota)
    {
        $data = $request->validate([
            'title' => ['required','string','max:150'],
            'content' => ['required','string'],
        ]);
        $nota->update($data);
        return redirect()->route('notas.show', $nota->id)->with('success','Nota actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notas $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('success','Nota eliminada');
    }
}
