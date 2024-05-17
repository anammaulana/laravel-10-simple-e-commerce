@extends('layouts.index')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full max-w-2xl">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden my-5">
                    <div class="bg-primary text-white text-center p-4">Profil Pengguna</div>

                    <div class="p-4">
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex mb-4">
                            <div class="w-1/3 text-center">
                                <img src="{{ url('storage/' . $user->image) }}" class="rounded-full w-1/2 mx-auto"
                                    alt="image_profile">
                            </div>
                            <div class="w-2/3">
                                <h5 class="text-lg">Nama: {{ $user->name }}</h5>
                                <p>Email: {{ $user->email }}</p>
                                <p>No Telepon: {{ $user->no_telepon }}</p>
                                <p>Alamat: {{ $user->address }}</p>
                                <p>Peran: {{ $user->is_admin ? 'Admin' : 'Anggota' }}</p>
                            </div>
                        </div>

                        <form action="{{ route('edit_profile') }}" method="post" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-bold mb-2">Nama</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name='name' value="{{ $user->name }}"
                                    placeholder="Nama">
                            </div>
                            <div class="mb-4">
                                <label for="notelepon" class="block text-sm font-bold mb-2">No Telepon</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name='no_telepon' value="{{ $user->no_telepon }}"
                                    placeholder="No Telepon">
                            </div>
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-bold mb-2">Alamat</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name='address' value="{{ $user->address }}"
                                    placeholder="Alamat">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-bold mb-2">Kata Sandi</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name='password' placeholder="Kata Sandi">
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-sm font-bold mb-2">Konfirmasi Kata Sandi</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name='password_confirmation'
                                    placeholder="Konfirmasi Kata Sandi">
                            </div>
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-bold mb-2">Gambar</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Perbarui Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
