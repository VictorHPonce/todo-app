<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index()
    {
        // Obtener todos los todos usando consulta SQL directa
        $todos = DB::select('SELECT * FROM todos ORDER BY created_at DESC');
        
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        // Validar el input
        $request->validate([
            'title' => 'required|max:255'
        ]);
        
        try {
            // Insertar usando consulta SQL directa
            DB::insert('INSERT INTO todos (title, completed) VALUES (?, ?)', [
                $request->title,
                0
            ]);
            
            return redirect()->route('todos.index')->with('success', 'Todo creado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('todos.index')->with('error', 'Error al crear la tarea: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Actualizar el estado de completado
            DB::update('UPDATE todos SET completed = ?, updated_at = NOW() WHERE id = ?', [
                $request->has('completed') ? 1 : 0,
                $id
            ]);
            
            return redirect()->route('todos.index')->with('success', 'Todo actualizado!');
        } catch (\Exception $e) {
            return redirect()->route('todos.index')->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Eliminar usando consulta SQL directa
        DB::delete('DELETE FROM todos WHERE id = ?', [$id]);
        
        return redirect()->route('todos.index')->with('success', 'Todo eliminado!');
    }
}