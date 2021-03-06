<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Collection::paginate(10);

        return view('collection.index', [
            'collection' => $collection
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('collection.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionRequest $request)
    {
         $data = $request->all();
         $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
         $data['photoBarcode'] = $request->file('photoBarcode')->store('assets/food', 'public');

         Collection::create($data);

         return redirect()->route('collection.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        return view('collection.edit', [
            'item' => $collection
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $data = $request->all();

        if($request->file('picturePath'))
        {
            $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }
        if($request->file('photoBarcode'))
        {
            $data['photoBarcode'] = $request->file('picturePath')->store('assets/food', 'public');
        }

        $collection->update($data);
        return redirect()->route('collection.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()->route('collection.index');
    }
}
