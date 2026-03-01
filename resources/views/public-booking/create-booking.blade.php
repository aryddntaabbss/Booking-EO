@extends('layouts.app')

@section('content')
    @php
        $errorToStep = [
            'user_name' => 1,
            'email' => 1,
            'phone' => 1,
            'event_date' => 2,
            'location' => 2,
            'notes' => 3,
            'payment_method' => 4,
        ];

        $initialStep = 1;

        foreach (array_keys($errors->toArray()) as $field) {
            $initialStep = max($initialStep, $errorToStep[$field] ?? 1);
        }
    @endphp

    <div id="booking-stepper" data-initial-step="{{ $initialStep }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 md:p-7">
        <h1 class="mb-2 text-2xl font-bold text-gray-900">Booking Stepper - {{ $package->name }}</h1>
        <p class="mb-6 text-sm text-gray-700">Harga paket: <span class="font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</span></p>

        <div class="mb-8">
            <div class="mb-4 h-2 rounded-full bg-gray-200">
                <div id="step-progress" class="h-2 rounded-full bg-emerald-700 transition-all duration-300" style="width: 20%"></div>
            </div>

            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                <div class="step-indicator flex min-w-max items-center gap-2 rounded-full border border-gray-200 px-4 py-2" data-step-indicator="1">
                    <span class="step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold">1</span>
                    <span class="text-xs font-medium">Data Pemesan</span>
                </div>
                <div class="h-px min-w-6 bg-gray-300"></div>
                <div class="step-indicator flex min-w-max items-center gap-2 rounded-full border border-gray-200 px-4 py-2" data-step-indicator="2">
                    <span class="step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold">2</span>
                    <span class="text-xs font-medium">Detail Event</span>
                </div>
                <div class="h-px min-w-6 bg-gray-300"></div>
                <div class="step-indicator flex min-w-max items-center gap-2 rounded-full border border-gray-200 px-4 py-2" data-step-indicator="3">
                    <span class="step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold">3</span>
                    <span class="text-xs font-medium">Catatan</span>
                </div>
                <div class="h-px min-w-6 bg-gray-300"></div>
                <div class="step-indicator flex min-w-max items-center gap-2 rounded-full border border-gray-200 px-4 py-2" data-step-indicator="4">
                    <span class="step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold">4</span>
                    <span class="text-xs font-medium">Pembayaran</span>
                </div>
                <div class="h-px min-w-6 bg-gray-300"></div>
                <div class="step-indicator flex min-w-max items-center gap-2 rounded-full border border-gray-200 px-4 py-2" data-step-indicator="5">
                    <span class="step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold">5</span>
                    <span class="text-xs font-medium">Review & Kirim</span>
                </div>
            </div>
        </div>

        <form id="booking-form" method="POST" action="{{ route('bookings.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <section data-step="1" class="mt-4 space-y-5">
                <h2 class="text-base font-semibold text-gray-900">Langkah 1: Data Pemesan</h2>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Nama
                    <input id="user_name" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="user_name" value="{{ old('user_name') }}" required>
                </label>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Email
                    <input id="email" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="email" name="email" value="{{ old('email') }}" required>
                </label>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    No. HP
                    <input id="phone" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="phone" value="{{ old('phone') }}" required>
                </label>
            </section>

            <section data-step="2" class="hidden mt-4 space-y-5">
                <h2 class="text-base font-semibold text-gray-900">Langkah 2: Detail Event</h2>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                    <p><span class="font-semibold">Paket dipilih:</span> {{ $package->name }}</p>
                    <p><span class="font-semibold">Total harga:</span> Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                </div>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Tanggal Event
                    <input id="event_date" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="date" name="event_date" value="{{ old('event_date') }}" required>
                </label>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Lokasi
                    <input id="location" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" type="text" name="location" value="{{ old('location') }}" required>
                </label>
            </section>

            <section data-step="3" class="hidden mt-4 space-y-5">
                <h2 class="text-base font-semibold text-gray-900">Langkah 3: Catatan Tambahan</h2>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Catatan
                    <textarea id="notes" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" name="notes" rows="5" placeholder="Contoh: tema acara, rundown singkat, dan kebutuhan khusus.">{{ old('notes') }}</textarea>
                </label>
            </section>

            <section data-step="4" class="hidden mt-4 space-y-5">
                <h2 class="text-base font-semibold text-gray-900">Langkah 4: Pembayaran</h2>

                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
                    Pembayaran dilakukan setelah booking dikirim. Setelah admin review, silakan upload bukti pembayaran di halaman Cek Status Booking.
                </div>

                <label class="block text-sm font-medium text-gray-700 my-3">
                    Metode Pembayaran
                    <select id="payment_method" name="payment_method" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none" required>
                        <option value="">Pilih metode</option>
                        <option value="transfer" @selected(old('payment_method') === 'transfer')>Transfer Bank</option>
                        <option value="ewallet" @selected(old('payment_method') === 'ewallet')>E-Wallet</option>
                        <option value="cash" @selected(old('payment_method') === 'cash')>Cash</option>
                    </select>
                </label>

                <label class="inline-flex items-start gap-2 text-sm text-gray-700">
                    <input id="payment_confirm" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600" required>
                    <span>Saya memahami bahwa booking akan berstatus <strong>pending</strong> sampai admin mengonfirmasi.</span>
                </label>
            </section>

            <section data-step="5" class="hidden mt-4 space-y-5">
                <h2 class="text-base font-semibold text-gray-900">Langkah 5: Review Booking</h2>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 text-sm text-gray-700">
                    <dl class="space-y-2">
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Nama</dt>
                            <dd id="review_user_name">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Email</dt>
                            <dd id="review_email">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">No. HP</dt>
                            <dd id="review_phone">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Paket</dt>
                            <dd>{{ $package->name }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Tanggal Event</dt>
                            <dd id="review_event_date">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Lokasi</dt>
                            <dd id="review_location">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Catatan</dt>
                            <dd id="review_notes">-</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="font-semibold">Metode Pembayaran</dt>
                            <dd id="review_payment_method">-</dd>
                        </div>
                        <div class="flex justify-between gap-4 border-t border-gray-200 pt-2">
                            <dt class="font-semibold">Total Harga</dt>
                            <dd class="font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <div class="flex items-center justify-between border-t border-gray-200 pt-5">
                <button type="button" id="prev-step" class="hidden rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Kembali</button>
                <div class="my-2 flex items-center gap-2">
                    <button type="button" id="next-step" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Lanjut</button>
                    <button type="submit" id="submit-step" class="hidden rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Kirim Booking</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        (() => {
            const stepper = document.getElementById('booking-stepper');
            const form = document.getElementById('booking-form');

            if (!stepper || !form) {
                return;
            }

            const totalSteps = 5;
            let currentStep = Number(stepper.dataset.initialStep || 1);

            const sections = Array.from(form.querySelectorAll('[data-step]'));
            const indicators = Array.from(stepper.querySelectorAll('[data-step-indicator]'));
            const progress = document.getElementById('step-progress');
            const prevButton = document.getElementById('prev-step');
            const nextButton = document.getElementById('next-step');
            const submitButton = document.getElementById('submit-step');

            const fieldMap = {
                user_name: document.getElementById('user_name'),
                email: document.getElementById('email'),
                phone: document.getElementById('phone'),
                event_date: document.getElementById('event_date'),
                location: document.getElementById('location'),
                notes: document.getElementById('notes'),
                payment_method: document.getElementById('payment_method'),
            };

            const reviewMap = {
                user_name: document.getElementById('review_user_name'),
                email: document.getElementById('review_email'),
                phone: document.getElementById('review_phone'),
                event_date: document.getElementById('review_event_date'),
                location: document.getElementById('review_location'),
                notes: document.getElementById('review_notes'),
                payment_method: document.getElementById('review_payment_method'),
            };

            function getRequiredFieldsByStep(step) {
                if (step === 1) {
                    return [fieldMap.user_name, fieldMap.email, fieldMap.phone];
                }

                if (step === 2) {
                    return [fieldMap.event_date, fieldMap.location];
                }

                if (step === 4) {
                    return [fieldMap.payment_method, document.getElementById('payment_confirm')];
                }

                return [];
            }

            function formatDate(value) {
                if (!value) {
                    return '-';
                }

                const date = new Date(value);

                if (Number.isNaN(date.getTime())) {
                    return value;
                }

                return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            }

            function updateReview() {
                reviewMap.user_name.textContent = fieldMap.user_name.value || '-';
                reviewMap.email.textContent = fieldMap.email.value || '-';
                reviewMap.phone.textContent = fieldMap.phone.value || '-';
                reviewMap.event_date.textContent = formatDate(fieldMap.event_date.value);
                reviewMap.location.textContent = fieldMap.location.value || '-';
                reviewMap.notes.textContent = fieldMap.notes.value || '-';
                reviewMap.payment_method.textContent = fieldMap.payment_method.value ? fieldMap.payment_method.options[fieldMap.payment_method.selectedIndex].text : '-';
            }

            function updateStepper() {
                sections.forEach((section) => {
                    const step = Number(section.dataset.step);
                    section.classList.toggle('hidden', step !== currentStep);
                });

                indicators.forEach((indicator) => {
                    const step = Number(indicator.dataset.stepIndicator);
                    const badge = indicator.querySelector('.step-badge');
                    const label = indicator.querySelector('span:last-child');

                    const baseIndicatorClass = 'step-indicator flex min-w-max items-center gap-2 rounded-full border px-4 py-2';
                    const baseBadgeClass = 'step-badge inline-flex h-7 w-7 items-center justify-center rounded-full border text-xs font-semibold';

                    indicator.style.backgroundColor = '';
                    indicator.style.borderColor = '';
                    indicator.style.color = '';
                    badge.style.backgroundColor = '';
                    badge.style.borderColor = '';
                    badge.style.color = '';

                    if (step < currentStep) {
                        indicator.className = `${baseIndicatorClass}`;
                        badge.className = `${baseBadgeClass}`;

                        indicator.style.backgroundColor = '#047857'; // emerald-700
                        indicator.style.borderColor = '#047857';
                        indicator.style.color = '#ffffff';
                        badge.style.backgroundColor = '#064e3b'; // emerald-900
                        badge.style.borderColor = '#064e3b';
                        badge.style.color = '#ffffff';
                    } else if (step === currentStep) {
                        indicator.className = `${baseIndicatorClass}`;
                        badge.className = `${baseBadgeClass}`;

                        indicator.style.backgroundColor = '#064e3b'; // emerald-900
                        indicator.style.borderColor = '#064e3b';
                        indicator.style.color = '#ffffff';
                        badge.style.backgroundColor = '#059669'; // emerald-600
                        badge.style.borderColor = '#059669';
                        badge.style.color = '#ffffff';
                    } else {
                        indicator.className = `${baseIndicatorClass} text-gray-500 bg-gray-50 border-gray-200`;
                        badge.className = `${baseBadgeClass} bg-white border-gray-300 text-gray-600`;
                    }

                    if (label) {
                        label.classList.toggle('font-semibold', step === currentStep);
                    }
                });

                const progressWidth = (currentStep / totalSteps) * 100;
                progress.style.width = `${progressWidth}%`;

                prevButton.classList.toggle('hidden', currentStep === 1);
                nextButton.classList.toggle('hidden', currentStep === totalSteps);
                submitButton.classList.toggle('hidden', currentStep !== totalSteps);

                if (currentStep === totalSteps) {
                    updateReview();
                }
            }

            function validateCurrentStep() {
                const requiredFields = getRequiredFieldsByStep(currentStep);

                for (const field of requiredFields) {
                    if (!field.checkValidity()) {
                        field.reportValidity();
                        return false;
                    }
                }

                return true;
            }

            nextButton.addEventListener('click', () => {
                if (!validateCurrentStep()) {
                    return;
                }

                currentStep = Math.min(totalSteps, currentStep + 1);
                updateStepper();
            });

            prevButton.addEventListener('click', () => {
                currentStep = Math.max(1, currentStep - 1);
                updateStepper();
            });

            Object.values(fieldMap).forEach((field) => {
                field?.addEventListener('input', updateReview);
            });

            updateStepper();
            updateReview();
        })();
    </script>
@endsection
