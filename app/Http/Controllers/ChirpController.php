<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index', [
            'chirps' => Chirp::latest()->get()
        ]);
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
 
        // Validate data
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);

        // Insert to database
        /*$request->user()->chirps()->create([
            'message' => $request->get('message'),
        ]);
        */
        $request->user()->chirps()->create($validated); // opcion 2 de instersion a DB
        
        return to_route('chirps.index')
            ->with('status', __('Chirp created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {   
        // Candado para que solo los creadores del chirp puedan editar
            //if(auth()->user()->isNot($chirp->user)){abort(403);}
        $this->authorize('update', $chirp);

        return view('chirps.edit',[
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        // Candado para que solo los creadores del chirp puedan editar
            //if(auth()->user()->isNot($chirp->user)){abort(403);}
        $this->authorize('update', $chirp);
        
        // Validate data
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);

        $chirp->update($validated);
        
        return to_route('chirps.index')
            ->with('status', __('Chirp updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        // Candado para que solo los creadores del chirp puedan editar
            //if(auth()->user()->isNot($chirp->user)){abort(403);}
        $this->authorize('update', $chirp);

        $chirp->delete();
        
        return to_route('chirps.index')
            ->with('status', __('Chirp deleted successfully!'));
    }
}
