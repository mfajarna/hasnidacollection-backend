<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                   <a href="{{ route('users.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                       + Create user
                   </a>
            </div>
            <div class="bg-white mt-5">
                <table class="table-auto w-full py-12">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Name</th>
                            <th class="border px-6 py-4">Email</th>
                            <th class="border px-6 py-4">Roles</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $user as $item )
                            <tr>
                                <td class="border px-6 py-4">{{ $item->id }}</td>
                                <td class="border px-6 py-4">{{ $item->name }}</td>
                                <td class="border px-6 py-4">{{ $item->email }}</td>
                                <td class="border px-6 py-4">{{ $item->roles }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('users.edit', $item->id) }}" class="inline-block text-indigo-500 font-bold">Edit</a>
                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline-block">
                                        {!! method_field('delete') .csrf_field() !!}
                                        <button type="submit" class="text-red-500 font-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border text-center p-5">
                                    Data tidak ditemukan!
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $user->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
