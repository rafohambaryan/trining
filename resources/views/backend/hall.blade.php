@extends('backend.layout.app')
@push('title' ,'Hall')
@push('page','Hall')
@section('content')
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
                        <tr class="line-halls-line" data-id="{{$line->id}}">
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
@endsection
@push('modal')
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
@endpush
@push('after-script')
    <script src="{{asset('/backend/js/hall/hall.js')}}"></script>
@endpush
