<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // отримання всіх страв (GET)
    public function index()
    {
        return response()->json(Menu::all(), 200);
    }

    // створення нової страви (POST)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $menuItem = Menu::create($validated);
        return response()->json($menuItem, 201);
    }

    // отримання конкретної страви за id (GET)
    public function show(string $id)
    {
        $menuItem = Menu::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'страва не знайдена'], 404);
        }
        return response()->json($menuItem, 200);
    }

    // оновлення страви (PATCH / PUT)
    public function update(Request $request, string $id)
    {
        $menuItem = Menu::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'страва не знайдена'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
        ]);

        $menuItem->update($validated);
        return response()->json($menuItem, 200);
    }

    // видалення страви (DELETE)
    public function destroy(string $id)
    {
        $menuItem = Menu::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'страва не знайдена'], 404);
        }

        $menuItem->delete();
        return response()->json(['message' => 'страву видалено успішно'], 200);
    }
}
