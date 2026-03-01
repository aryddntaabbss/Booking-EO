@extends('layouts.app')

@section('content')
    <div class="mb-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
        <h1 class="mb-3 text-2xl font-bold text-gray-900">Cek Status Booking</h1>

        <form method="POST" action="{{ route('bookings.status.search') }}" class="grid gap-4">
            @csrf
            <label class="block text-sm font-medium text-gray-700">
                Kode Booking
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="booking_code" value="{{ old('booking_code') }}" required>
            </label>

            <label class="block text-sm font-medium text-gray-700">
                Email
                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <button type="submit" class="inline-flex w-fit rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Cek</button>
        </form>
    </div>

    @isset($booking)
        @php
            $badgeClasses = match ($booking->status) {
                'pending' => 'bg-amber-100 text-amber-700',
                'confirmed' => 'bg-green-100 text-green-700',
                'rejected' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-700',
            };
        @endphp

        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
            <h3 class="mb-3 text-lg font-semibold text-gray-900">Detail Booking</h3>
            <p class="text-sm text-gray-700"><span class="font-semibold">Kode:</span> {{ $booking->booking_code }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Nama:</span> {{ $booking->user_name }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Paket:</span> {{ $booking->package->name }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Tanggal Event:</span> {{ $booking->event_date->format('d M Y') }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Total:</span> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-700">
                <span class="font-semibold">Status:</span>
                <span class="ml-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClasses }}">{{ strtoupper($booking->status) }}</span>
            </p>

            @if (!$booking->payment_proof)
                <hr class="my-5 border-gray-200">
                <h4 class="mb-3 text-base font-semibold text-gray-900">Upload Bukti Pembayaran</h4>
                <form method="POST" action="{{ route('bookings.payment-proof', $booking) }}" enctype="multipart/form-data" class="grid gap-4">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700">
                        Email konfirmasi
                        <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="email" name="email" required>
                    </label>
                    <label class="block text-sm font-medium text-gray-700">
                        File Bukti (jpg/png, max 2MB)
                        <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="file" name="payment_proof" accept="image/*" required>
                    </label>
                    <button class="inline-flex w-fit rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800" type="submit">Upload</button>
                </form>
            @else
                <p class="mt-4 text-sm text-gray-700"><span class="font-semibold">Bukti pembayaran:</span> sudah diupload.</p>
            @endif
        </div>
    @endisset
@endsection
