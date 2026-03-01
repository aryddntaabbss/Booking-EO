@extends('layouts.app')

@section('content')
    <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
        <h1 class="mb-3 text-2xl font-bold text-gray-900">{{ $package->name }}</h1>
        <p class="text-sm text-gray-700"><span class="font-semibold">Kategori:</span> {{ $package->category->name }}</p>
        <p class="my-3 text-sm text-gray-600">{{ $package->description }}</p>
        <p class="text-sm text-gray-700"><span class="font-semibold">Harga:</span> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-700"><span class="font-semibold">Maks tamu:</span> {{ $package->max_guest ?: '-' }}</p>
        <p class="mb-4 text-sm text-gray-700"><span class="font-semibold">Durasi:</span> {{ $package->duration ?: '-' }}</p>
        <a class="inline-flex rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800" href="{{ route('bookings.create', $package) }}">Booking Sekarang</a>
    </div>
@endsection
