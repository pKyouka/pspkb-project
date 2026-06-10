@extends('layouts.admin')

@section('title', 'Tambah Berita/Artikel')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Tambah Berita/Artikel</h2>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.posts._form')
        <div class="flex items-center space-x-2 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection
