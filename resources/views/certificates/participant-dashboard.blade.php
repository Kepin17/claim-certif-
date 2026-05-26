@extends('layouts.user-layout')

@section('title', 'My Certificates')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">My Certificates</h1>
                
                <form method="GET" action="{{ route('certificate.participant-dashboard') }}" class="mb-6">
                    <div class="flex gap-3">
                        <input type="email" name="email" placeholder="Enter your email" value="{{ old('email', $email) }}"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Search
                        </button>
                    </div>
                </form>

                @if($email && $certificates->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>No certificate claims found for this email.</p>
                    </div>
                @endif

                @if($certificates->isNotEmpty())
                <div class="space-y-4">
                    @foreach($certificates as $cert)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $cert->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $cert->email }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase
                                @if($cert->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($cert->status === 'approved') bg-blue-100 text-blue-800
                                @elseif($cert->status === 'generated') bg-purple-100 text-purple-800
                                @elseif($cert->status === 'sent') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $cert->status }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Event:</span> {{ $cert->event }}</p>
                            @if($cert->certificate_type_name)
                            <p><span class="font-medium">Role:</span> {{ $cert->certificate_type_name }}</p>
                            @endif
                            @if($cert->certificate_number)
                            <p><span class="font-medium">Certificate Number:</span> {{ $cert->certificate_number }}</p>
                            @endif
                            <p><span class="font-medium">Submitted:</span> {{ $cert->created_at->format('d F Y, H:i') }}</p>
                            @if($cert->approved_at)
                            <p><span class="font-medium">Processed:</span> {{ $cert->approved_at->format('d F Y, H:i') }}</p>
                            @endif
                            @if($cert->rejection_reason)
                            <p class="text-red-600"><span class="font-medium">Rejection Reason:</span> {{ $cert->rejection_reason }}</p>
                            @endif
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('certificate.status', $cert->unique_key) }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm">
                                View Details
                            </a>
                            @if(in_array($cert->status, ['generated', 'sent']))
                            <a href="{{ route('certificate.download', ['key' => $cert->unique_key]) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                            @endif
                            @if($cert->status === 'rejected' && $cert->eventRelation?->isClaimOpen())
                            <a href="{{ route('certificate.claim-form', $cert->eventRelation->slug) }}" 
                               class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm">
                                <i class="fas fa-redo mr-1"></i> Re-submit
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
