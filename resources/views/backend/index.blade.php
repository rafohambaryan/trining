@extends('backend.layout.app')
@section('content')
    <div class="row">
        @include('backend.layout.components.dashboard.card',[
                    'name' => 'Films',
                    'url' => url('/admin/films'),
                    'view' => 'View Details',
                    'bg' => 'bg-primary'
                ])
        @include('backend.layout.components.dashboard.card',[
                    'name' => 'Hall',
                    'url' => url('/admin/hall'),
                    'view' => 'View Details',
                    'bg' => 'bg-danger'
                ])
    </div>
@endsection
@push('after-script')
    <script src="{{asset('/backend/assets/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('/backend/assets/demo/chart-bar-demo.js')}}"></script>
@endpush
