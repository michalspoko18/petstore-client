<?php

namespace App\Http\Controllers;

use App\Services\PetStore;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected PetStore $petStore;

    public function __construct(PetStore $petStore) {
        $this->petStore = $petStore;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pets = $this->petStore->findByStatus();
            return view('pets.index', ['pets' => $pets]);
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:available,pending,sold',
                'category_name' => 'nullable|string',
                'photo_url' => 'nullable|url',
            ]);
            
            $petData = [
                'name' => $validated['name'],
                'status' => $validated['status'],
                'category' => [
                    'id' => 0,
                    'name' => $validated['category_name'] ?? 'default'
                ],
                'photoUrls' => [$validated['photo_url'] ?? ''],
                'tags' => []
            ];
            
            $this->petStore->addPet($petData);
            
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało dodane pomyślnie');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pet = $this->petStore->getPet($id);
            return view('pets.show', ['pet' => $pet]);
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $pet = $this->petStore->editPet($id);
            return view('pets.edit', ['pet' => $pet]);
        } catch (\Exception $e) {
            return back()->with('error', 'Nie udało się znaleźć zwierzęcia: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
