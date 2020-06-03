@extends('backend.layout.app')
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Films</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Films</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header costume-card-header-film">
                        <div><i class="fas fa-table mr-1"></i>All Films</div>
                        <button class="btn btn-primary add-new-film">New Film</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableFilmsList">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="max-width-150"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($films as $film)
                                    <tr class="card-film-tr" data-id="{{$film->id}}">
                                        <td class="name">{{$film->name}}</td>
                                        <td class="description">{{$film->description}}</td>
                                        <td>
                                            <div class="crud-costume">
                                                <i class="fas fa-tasks get-checked-film"></i>
                                                <i class="fas fa-edit update-film"></i>
                                                <i class="fas fa-trash-alt delete-film"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
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
    <script src="{{asset('/backend/js/films/add-films.js')}}"></script>
@endpush
