@props(['headers' => [], 'rows' => [], 'striped' => true])

<div class="table-card">
    <table>
        @if(!empty($headers))
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" style="text-align: center; color: var(--muted);">
                        هیچ داده‌ای موجود نیست
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
