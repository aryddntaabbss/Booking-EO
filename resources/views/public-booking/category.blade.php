@extends('layouts.app')

@section('content')
    <div class="mb-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
        <p class="text-sm text-gray-600">{{ $category->description }}</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($category->packages as $package)
            <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $package->name }}</h3>
                <p class="mb-3 text-sm text-gray-600">{{ $package->description }}</p>
                <p class="text-sm text-gray-700"><span class="font-semibold">Harga:</span> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-700"><span class="font-semibold">Maks tamu:</span> {{ $package->max_guest ?: '-' }}</p>
                <p class="mb-4 text-sm text-gray-700"><span class="font-semibold">Durasi:</span> {{ $package->duration ?: '-' }}</p>
                <a class="inline-flex rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800" href="{{ route('packages.show', $package) }}">Detail</a>
            </div>
        @empty
            <div class="rounded-xl bg-white p-5 text-sm text-gray-600 shadow-sm ring-1 ring-gray-200">Belum ada paket aktif di kategori ini.</div>
        @endforelse
    </div>
@endsection
