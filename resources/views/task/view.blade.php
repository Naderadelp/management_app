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
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('task-managments.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Tasks
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg text-sm">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Task Header -->
            <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $taskManagment->title }}</h1>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full w-fit
                        @if($taskManagment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($taskManagment->status === 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $taskManagment->status)) }}
                    </span>
                </div>
            </div>

            <!-- Task Content -->
            <div class="p-6 md:p-8">
                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Description</h2>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $taskManagment->description ?: 'No description provided.' }}</p>
                    </div>
                </div>

                <!-- Task Details -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Created At</h3>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $taskManagment->created_at->format('M d, Y') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $taskManagment->created_at->format('h:i A') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Updated At</h3>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $taskManagment->updated_at->format('M d, Y') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $taskManagment->updated_at->format('h:i A') }}</p>
                    </div>
                    @if($taskManagment->user)
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Assigned To</h3>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $taskManagment->user->name }}</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $taskManagment->user->email }}</p>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('task-managments.edit', $taskManagment->id) }}"
                       class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition text-center">
                        Edit Task
                    </a>
                    <form method="POST" action="{{ route('task-managments.destroy', $taskManagment->id) }}"
                          onsubmit="return confirm('Are you sure you want to delete this task?');"
                          class="flex-1 sm:flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-6 rounded-lg transition">
                            Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
