@extends('layouts.ap')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header bg-primary text-white text-center">Profil Pengguna</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-4 text-center">
                                <img src="{{ url('storage/' . $user->image) }}" class="rounded-circle w-50"
                                    alt="image_profile">
                            </div>
                            <div class="col-md-8">
                                <h5>Nama: {{ $user->name }}</h5>
                                <p>Email: {{ $user->email }}</p>
                                <p>No Telepon: {{ $user->no_telepon }}</p>
                                <p>Alamat: {{ $user->address }}</p>
                                <p>Peran: {{ $user->is_admin ? 'Admin' : 'Anggota' }}</p>
                            </div>
                        </div>

                        <form action="{{ route('edit_profile') }}" method="post" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input class="form-control" type="text" name='name' value="{{ $user->name }}"
                                    placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label for="notelepon">No Telepon</label>
                                <input class="form-control" type="text" name='no_telepon' value="{{ $user->no_telepon }}"
                                    placeholder="No Telepon">
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <input class="form-control" type="text" name='address' value="{{ $user->address }}"
                                    placeholder="Alamat">
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input class="form-control" type="password" name='password' placeholder="Kata Sandi">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                <input class="form-control" type="password" name='password_confirmation'
                                    placeholder="Konfirmasi Kata Sandi">
                            </div>
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Perbarui Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
