@extends('backend.layout.app')
@push('title' ,'Setting')
@push('page','Setting')
@section('content')
    <div class="card mb-4">
        <div class="card-header costume-card-header-film">
            <div><i class="fas fa-cog"></i> Settings</div>
        </div>
        <div class="card-body">

        </div>
    </div>
@endsection
@push('after-script')
    <script src="{{asset('/backend/js/settings/settings.js')}}"></script>
@endpush

