@props(['id', 'title', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full',
    ];
@endphp

<div id="{{ $id }}" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-xl {{ $sizeClasses[$size] ?? $sizeClasses['md'] }} w-full mx-4 max-h-[90vh] overflow-hidden">
        @if($title)
            <div class="modal-header px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                <button type="button" class="modal-close text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <div class="modal-body p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    // Modal functionality
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Event listeners for modal close buttons
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-close').forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.modal-overlay');
                if (modal) {
                    hideModal(modal.id);
                }
            });
        });

        // Close modal when clicking overlay
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideModal(this.id);
                }
            });
        });
    });
</script>