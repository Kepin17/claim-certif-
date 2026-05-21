<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    @include('layouts.user-navigation')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center mb-8">
                    @if($certificate->status === 'generated' || $certificate->status === 'sent')
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-green-600 mb-2">Valid Certificate</h1>
                        <p class="text-gray-600">This certificate has been verified and is authentic.</p>
                    @else
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-red-600 mb-2">Invalid Certificate</h1>
                        <p class="text-gray-600">This certificate is not valid or has been revoked.</p>
                    @endif
                </div>

                <div class="border border-gray-200 rounded-lg p-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Certificate Number:</span>
                        <span class="font-semibold">{{ $certificate->certificate_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Participant Name:</span>
                        <span class="font-semibold">{{ $certificate->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $certificate->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Event:</span>
                        <span class="font-semibold">{{ $certificate->event }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Participant Number:</span>
                        <span class="font-semibold">{{ $certificate->participant_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-semibold uppercase {{ $certificate->status === 'generated' || $certificate->status === 'sent' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $certificate->status }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Issued Date:</span>
                        <span class="font-semibold">{{ $certificate->approved_at ? $certificate->approved_at->format('d F Y') : 'N/A' }}</span>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-gray-500 text-sm">Verified on {{ now()->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
