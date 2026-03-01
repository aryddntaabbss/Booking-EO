@extends('layouts.app')

@section('content')
    <div class="mb-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Website Booking EO &amp; WO</h1>
        <p class="text-sm text-gray-600">Pilih kategori event untuk melihat paket yang tersedia.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($categories as $category)
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <div class="mb-2 flex items-center justify-between gap-2">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                    <span @class([
                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                        'bg-blue-100 text-blue-700' => $category->organizer_type === 'wo',
                        'bg-teal-100 text-teal-700' => $category->organizer_type === 'eo',
                    ])>{{ strtoupper($category->organizer_type) }}</span>
                </div>
                <p class="mb-3 text-sm text-gray-600">{{ $category->description }}</p>
                <p class="mb-4 text-sm text-gray-700"><span class="font-semibold">{{ $category->packages->count() }}</span> paket tersedia</p>
                <a class="inline-flex rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800" href="{{ route('categories.show', $category) }}">Lihat Paket</a>
            </div>
        @empty
            <div class="rounded-xl bg-white p-5 text-sm text-gray-600 shadow-sm ring-1 ring-gray-200">Belum ada kategori aktif.</div>
        @endforelse
    </div>
@endsection
