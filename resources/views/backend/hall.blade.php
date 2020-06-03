@extends('backend.layout.app')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Hall</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hall</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header costume-card-header-film">
                        <div><i class="fas fa-table mr-1"></i>Hall</div>
                        <div>
                            <button class="btn btn-primary add-new-line-hall">New Line</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive hall-content">
                            <table class="costume_table">
                                @foreach($lines as $line)
                                    <tr>
                                        <th><i class="far fa-edit line-edit"></i> <i class="far fa-trash-alt ml-1 mr-1 line-delete"></i>{{$line->name}} N {{$line->order}}</th>
                                        @foreach($line->counter as $heir)
                                            <td data-id="{{$heir->id}}">{{$heir->order}}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2019</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal fade bd-example-modal-lg" id="hallModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="hallModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hallModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body append-content-modal">

                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary click-save-add-or-update-film">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-script')
    <script src="{{asset('/backend/js/hall/hall.js')}}"></script>
@endpush
