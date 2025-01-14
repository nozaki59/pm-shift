<x-template title="PMシフト表" css=".css">
    <div>
        <form action="{{ route('shifts.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">インポート</button>
        </form>
    </div>
</x-template>
