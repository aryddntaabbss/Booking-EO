<?php

namespace App\Http\Controllers;

use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PublicBookingController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with(['packages' => fn ($query) => $query->where('is_active', true)->orderBy('price')])
            ->orderBy('name')
            ->get();

        return view('public-booking.index', compact('categories'));
    }

    public function category(Category $category)
    {
        $category->load(['packages' => fn ($query) => $query->where('is_active', true)->orderBy('price')]);

        abort_unless($category->is_active, 404);

        return view('public-booking.category', compact('category'));
    }

    public function package(Package $package)
    {
        abort_unless($package->is_active, 404);

        return view('public-booking.package', compact('package'));
    }

    public function create(Package $package)
    {
        abort_unless($package->is_active, 404);

        return view('public-booking.create-booking', compact('package'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', Rule::exists('packages', 'id')->where('is_active', true)],
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'location' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $package = Package::query()->findOrFail($validated['package_id']);

        $hasBlockedDate = BlockedDate::query()
            ->where('package_id', $package->id)
            ->whereDate('event_date', $validated['event_date'])
            ->exists();

        if ($hasBlockedDate) {
            throw ValidationException::withMessages([
                'event_date' => 'Tanggal tidak tersedia untuk paket ini.',
            ]);
        }

        $hasConfirmedBooking = Booking::query()
            ->where('package_id', $package->id)
            ->whereDate('event_date', $validated['event_date'])
            ->where('status', 'confirmed')
            ->exists();

        if ($hasConfirmedBooking) {
            throw ValidationException::withMessages([
                'event_date' => 'Tanggal sudah terisi untuk paket yang dipilih.',
            ]);
        }

        $booking = Booking::query()->create([
            ...$validated,
            'total_price' => $package->price,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('bookings.status.form')
            ->with('booking_success', "Booking berhasil. Kode booking Anda: {$booking->booking_code}");
    }

    public function statusForm()
    {
        return view('public-booking.status');
    }

    public function statusSearch(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $booking = Booking::query()
            ->with('package.category')
            ->where('booking_code', $validated['booking_code'])
            ->where('email', $validated['email'])
            ->first();

        return view('public-booking.status', compact('booking'));
    }

    public function uploadPaymentProof(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'payment_proof' => ['required', 'image', 'max:2048'],
        ]);

        abort_unless($booking->email === $validated['email'], 403);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $booking->update([
            'payment_proof' => $path,
        ]);

        return redirect()
            ->route('bookings.status.form')
            ->with('booking_success', 'Bukti pembayaran berhasil diupload.');
    }
}
