@extends('layouts.app')

@section('content')
    <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Form Booking - {{ $package->name }}</h1>
        <p class="mb-4 text-sm text-gray-700">Harga paket: <span class="font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</span></p>

        <form method="POST" action="{{ route('bookings.store') }}" class="grid gap-4">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <label class="block text-sm font-medium text-gray-700">
                Nama
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="user_name" value="{{ old('user_name') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                Email
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                No. HP
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="phone" value="{{ old('phone') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                Tanggal Event
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="date" name="event_date" value="{{ old('event_date') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                Lokasi
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="location" value="{{ old('location') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                Catatan
                <textarea class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" name="notes" rows="4">{{ old('notes') }}</textarea>
            </label>

            <button type="submit" class="inline-flex w-fit rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Kirim Booking</button>
        </form>
    </div>
@endsection
