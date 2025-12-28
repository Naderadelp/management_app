<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Tasks</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Dark mode - respect system preference or use dark by default
        if (!('theme' in localStorage)) {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } else if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Task Management</h1>
            <div class="flex gap-3">
                <a href="{{ route('task-managments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                    Create New Task
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if($taskManagments->count() > 0)
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($taskManagments as $task)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $task->title }}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($task->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($task->status === 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                            {{ Str::limit($task->description, 100) }}
                        </p>

                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <p>Created: {{ $task->created_at->format('M d, Y') }}</p>
                            @if($task->user)
                                <p>Assigned to: {{ $task->user->name }}</p>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('task-managments.show', $task->id) }}"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-2 px-4 rounded-lg transition">
                                View
                            </a>
                            <a href="{{ route('task-managments.edit', $task->id) }}"
                               class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center font-medium py-2 px-4 rounded-lg transition">
                                Update
                            </a>
                            <form method="POST" action="{{ route('task-managments.destroy', $task->id) }}" class="flex-1"
                                  onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $taskManagments->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-600 dark:text-gray-400 text-lg">No tasks found. Create your first task!</p>
                <a href="{{ route('task-managments.create') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                    Create Task
                </a>
            </div>
        @endif
    </div>

    <script>
        // Hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.transition = 'opacity 0.5s ease-out';
                    successMessage.style.opacity = '0';
                    setTimeout(function() {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>

