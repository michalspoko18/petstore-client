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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
