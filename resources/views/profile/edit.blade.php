@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<!-- Back to Home Button -->
<div class="text-center mt-1 mb-6">
    <a href="{{ route('barangs.index') }}" 
       class="inline-flex items-center px-8 py-3 text-white text-sm font-medium bg-blue-700 hover:bg-blue-800 rounded-full shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1">
        <i class="bi bi-house-door mr-2"></i> Back to Home
    </a>
</div>
@endsection