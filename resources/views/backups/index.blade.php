@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold">Backup Manager</h1>
            <p class="text-blue-100 mt-2">Create, download, delete, and restore database backups safely from here.</p>
            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="space-y-2">
                    <p class="text-blue-100 text-sm">Daily automatic backups are created at 02:00. Use the manual tools below for immediate restore and archive control.</p>
                </div>
                <form action="{{ route('backups.store') }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 transition text-white font-semibold py-3 px-5 rounded-lg">
                        Create Backup Now
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-200">Restore From Backup</h2>
            <p class="text-gray-400 mt-2">Upload a saved backup file to restore the database. This operation will overwrite current data.</p>

            <form action="{{ route('backups.uploadRestore') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 sm:grid-cols-[1fr_auto]">
                @csrf
                <div>
                    <label for="backup_file" class="block text-sm font-semibold text-gray-300 mb-2">Backup File</label>
                    <input id="backup_file" type="file" name="backup_file" accept=".sql,.sqlite" class="w-full rounded-lg border border-gray-600 bg-gray-900 text-gray-100 px-4 py-3" required>
                    @error('backup_file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 transition text-gray-900 font-semibold py-3 px-5 rounded-lg">
                        Restore Backup
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-200">Available Backups</h2>
                    <p class="text-gray-400 mt-2">Download, delete, or restore any backup file stored in <code>storage/app/backups</code>.</p>
                </div>
                <div class="text-right text-sm text-gray-400">
                    Backup files are named <span class="font-semibold">backup_YYYY_MM_DD_HHMMSS.sql</span> or <span class="font-semibold">backup_YYYY_MM_DD_HHMMSS.sqlite</span>.
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-200 border-separate border-spacing-y-2">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 font-semibold text-gray-300">File Name</th>
                            <th class="px-4 py-3 font-semibold text-gray-300">Size</th>
                            <th class="px-4 py-3 font-semibold text-gray-300">Created</th>
                            <th class="px-4 py-3 font-semibold text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $backup)
                            <tr class="bg-gray-900 rounded-2xl">
                                <td class="px-4 py-4 break-all text-gray-100">{{ $backup['name'] }}</td>
                                <td class="px-4 py-4 text-gray-300">{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                                <td class="px-4 py-4 text-gray-300">{{ \Illuminate\Support\Carbon::createFromTimestamp($backup['modified'])->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-4 space-x-2">
                                    <a href="{{ route('backups.download', $backup['name']) }}" class="inline-flex items-center rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-600 transition">
                                        Download
                                    </a>
                                    <button type="button" data-backup="{{ $backup['name'] }}" onclick="openRestoreModal(this.dataset.backup)" class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-gray-900 hover:bg-amber-400 transition">
                                        Restore
                                    </button>
                                    <form action="{{ route('backups.destroy', $backup['name']) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete backup? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">No backups found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="restore-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-gray-900 p-6 shadow-2xl">
        <h3 class="text-2xl font-bold text-white">Restore Backup</h3>
        <p id="restore-modal-description" class="mt-2 text-gray-300">This will overwrite current database data. Please confirm that you want to proceed.</p>

        <form id="restore-confirm-form" action="{{ route('backups.restore') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="backup_name" id="restore-backup-name">
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" onclick="closeRestoreModal()" class="w-full sm:w-auto rounded-lg border border-gray-600 bg-transparent px-5 py-3 text-sm font-semibold text-gray-200 hover:bg-white/5 transition">
                    Cancel
                </button>
                <button type="submit" class="w-full sm:w-auto rounded-lg bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-500 transition">
                    Yes, restore backup
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRestoreModal(filename) {
        document.getElementById('restore-backup-name').value = filename;
        document.getElementById('restore-modal').classList.remove('hidden');
    }

    function closeRestoreModal() {
        document.getElementById('restore-modal').classList.add('hidden');
    }
</script>
@endsection