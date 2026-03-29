<?php
namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function catalogue() {
        $produits = Produit::where('archive', false)->where('stock', '>', 0)->get();
        return view('catalogue', compact('produits'));
    }

    public function index() {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }

    public function create() {
        return view('produits.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        Produit::create($data);
        return redirect()->route('produits.index')->with('success', 'Burger ajouté avec succès !');
    }

    public function show(Produit $produit) {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit) {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit) {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix'        => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        } else {
            unset($data['image']);
        }

        $produit->update($data);
        return redirect()->route('produits.index')->with('success', 'Burger modifié avec succès !');
    }

    public function destroy(Produit $produit) {
        $produit->update(['archive' => true]);
        return redirect()->route('produits.index')->with('success', 'Burger archivé !');
    }
}
