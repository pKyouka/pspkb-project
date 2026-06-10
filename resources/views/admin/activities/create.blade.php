@extends('layouts.admin')

@section('title', 'Tambah Aktivitas')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Tambah Aktivitas</h2>
@endsection

@section('content')
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
    <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.posts._form')
        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Simpan Aktivitas</button>
            <a href="{{ route('admin.activities.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection
