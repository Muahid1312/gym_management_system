@props(['id', 'title' => 'Confirm Action', 'message' => 'Are you sure you want to proceed?', 'confirmText' => 'Confirm', 'cancelText' => 'Cancel', 'confirmVariant' => 'danger'])

<x-modal id="{{ $id }}" size="sm">
    <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>

        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-sm text-gray-500 mb-6">{{ $message }}</p>

        <div class="flex justify-center space-x-3">
            <button type="button" class="modal-close px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ $cancelText }}
            </button>
            <button type="button" class="confirm-action px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</x-modal>