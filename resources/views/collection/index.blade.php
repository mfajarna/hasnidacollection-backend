<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('collection.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create collection
                </a>
            </div>
            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th class="border px-6 py-4">ID</th>
                        <th class="border px-6 py-4">Name</th>
                        <th class="border px-6 py-4">Stock</th>
                        <th class="border px-6 py-4">Price</th>
                        <th class="border px-6 py-4">Rate</th>
                        <th class="border px-6 py-4">Types</th>
                        <th class="border px-6 py-4">Category</th>
                        <th class="border px-6 py-4">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($collection as $item)
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id }}</td>
                                <td class="border px-6 py-4 ">{{ $item->name }}</td>
                                <td class="border px-6 py-4 text-center">{{ $item->stock }}</td>
                                <td class="border px-6 py-4">{{ number_format($item->price) }}</td>
                                <td class="border px-6 py-4">{{ $item->rate }}</td>
                                <td class="border px-6 py-4">{{ $item->types }}</td>
                                <td class="border px-6 py-4">{{ $item->category }}</td>
                                <td class="border px-6 py- text-center">
                                    <a href="{{ route('collection.edit', $item->id) }}" class="inline-block text-blue-500 font-bold py-2 px-4 mx-2 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('collection.destroy', $item->id) }}" method="POST" class="inline-block">
                                        {!! method_field('delete') . csrf_field() !!}
                                        <button type="submit" class="text-red-500 font-bold py-2 px-4 mx-2 rounded inline-block">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                               <td colspan="8" class="border text-center p-5">
                                   Data Tidak Ditemukan
                               </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $collection->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
