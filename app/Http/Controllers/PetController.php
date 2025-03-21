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
    public function index(Request $request)
    {
        try {
            $status = $request->query('status', 'available'); // Domyślnie 'available' jeśli nie podano
            
            // Walidacja statusu
            if (!in_array($status, ['available', 'pending', 'sold'])) {
                $status = 'available'; // Fallback do domyślnej wartości jeśli nieprawidłowy status
            }
            
            $pets = $this->petStore->findByStatus($status);
            
            return view('pets.index', [
                'pets' => $pets,
                'currentStatus' => $status
            ]);
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
            $pet = $this->petStore->getPet($id);
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:available,pending,sold',
                'category_name' => 'nullable|string',
                'photo_url' => 'nullable|url',
            ]);
            
            $petData = [
                'id' => (int)$id,
                'name' => $validated['name'],
                'status' => $validated['status'],
                'category' => [
                    'id' => 0,
                    'name' => $validated['category_name'] ?? 'default'
                ],
                'photoUrls' => [$validated['photo_url'] ?? ''],
                'tags' => []
            ];
            
            $this->petStore->updatePet($petData);
            
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało zaktualizowane pomyślnie');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd: ' . $e->getMessage())->withInput();
        }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->petStore->deletePet($id);
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało usunięte pomyślnie');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }
}
