<?php

namespace App\Http\Controllers;

use App\Models\UserStore;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stores = UserStore::when($request["search"] ?? null, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%");
        })->orderBy('created_at', 'ASC')->paginate(3);
        
        return Inertia::render('Stores/index',[
            'filters' => $request->all('search'),
            "stores" => $stores
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Stores/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        UserStore::create($request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'user_id' => Auth()->user()->id
        ]));

        return redirect(route('user-store.index'))->with('success', 'Store Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Stores/Edit', [
            "store" => UserStore::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserStore $userStore)
    {
        $userStore->update(
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'location' => 'required',
                'user_id' => Auth()->user()->id
            ])
        );
        return redirect(route('user-store.index'))->with('success', 'Store Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $data = UserStore::find($id)->delete();
        return redirect(route('user-store.index'))->with('success', 'Store Successfully Deleted');
    }
}
