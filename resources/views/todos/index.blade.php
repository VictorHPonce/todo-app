<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 70%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 12px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .todo-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin: 10px 0;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .todo-item.completed {
            opacity: 0.6;
            border-left-color: #28a745;
        }
        .todo-item.completed .todo-text {
            text-decoration: line-through;
        }
        .todo-text {
            flex: 1;
            margin: 0 15px;
            font-size: 16px;
        }
        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
            margin-left: 5px;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #1e7e34;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .no-todos {
            text-align: center;
            color: #666;
            font-style: italic;
            margin: 40px 0;
        }
        .error-list {
            color: red;
            margin-bottom: 20px;
        }
        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Mi Lista de Tareas Actions</h1>
        <h1>Matheo</h1>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario para agregar nuevos todos -->
        <form action="{{ route('todos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="title" placeholder="Escribe una nueva tarea..." required>
                <button type="submit">Agregar Tarea</button>
            </div>
        </form>

        @if($errors->any())
            <div class="error-list">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Lista de todos -->
        @if(count($todos) > 0)
            @foreach($todos as $todo)
                <div class="todo-item {{ $todo->completed ? 'completed' : '' }}">
                    <form action="{{ route('todos.update', $todo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" name="completed" onchange="this.form.submit()" 
                               {{ $todo->completed ? 'checked' : '' }}>
                    </form>
                    
                    <div class="todo-text">
                        {{ $todo->title }}
                        <small style="color: #666; display: block;">
                            Creado: {{ date('d/m/Y H:i', strtotime($todo->created_at)) }}
                        </small>
                    </div>
                    
                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-small btn-danger" 
                                onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="no-todos">
                <p>¡No hay tareas pendientes! 🎉</p>
                <p>Agrega una nueva tarea arriba para comenzar.</p>
            </div>
        @endif

        <div style="margin-top: 30px; text-align: center; color: #666; font-size: 14px;">
            Total de tareas: {{ count($todos) }} | 
            Completadas: {{ count(array_filter($todos, function($todo) { return $todo->completed; })) }}
        </div>
    </div>
</body>
</html>