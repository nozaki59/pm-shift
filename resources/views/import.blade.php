<x-template title="PMシフト表" css="import.css">
    <div class="flex justify-center items-center w-full min-h-[100dvh]">
        <div class="md:w-2/3 w-full h-[300px] py-5 flex justify-center items-center bg-orange-100">
            <form action="{{ route('shifts.import') }}" method="POST" enctype="multipart/form-data" class="max-md:flex max-md:flex-col max-md:justify-center max-md:items-center">
                @csrf
                <input type="file" name="file" required>
                <button type="submit" class="btn shadow px-3 py-2 bg-gray-300 max-md:mt-10">インポート</button>
            </form>
        </div>
    </div>
</x-template>
