<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Chirp;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(), // this passes the chirps and associated ID's, with (eger load), lates(reverse chronological order)
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
    public function store(StorePostRequest $request, Chirp $chirp): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->chirps()->create($validated); //stored the new chirp from the associated user as long as its valid

        return redirect(route('chirps.index'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp); //enables us to update the chirp by editing it
        
        $validated = $request->validated(); //ensure validation
       
        $chirp->update($validated); //update the chirp as long as its valid

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete(); //calls the delete function in the policy

        return redirect(route('chirps.index'));
    }
}
