<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - View Task</title>

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
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('task-managments.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 mb-4 inline-block">
                ← Back to Tasks
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $taskManagment->title }}</h1>
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($taskManagment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($taskManagment->status === 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $taskManagment->status)) }}
                </span>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h2>
                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $taskManagment->description }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Created At</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $taskManagment->created_at->format('F d, Y h:i A') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Updated At</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $taskManagment->updated_at->format('F d, Y h:i A') }}</p>
                </div>
                @if($taskManagment->user)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Assigned To</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $taskManagment->user->name }}</p>
                    </div>
                @endif
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('task-managments.edit', $taskManagment->id) }}"
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-6 rounded-lg transition">
                    Update Task
                </a>
                <form method="POST" action="{{ route('task-managments.destroy', $taskManagment->id) }}"
                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition">
                        Delete Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

