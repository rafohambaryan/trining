<div class="col-xl-3 col-md-6">
    <div class="card {{$bg ?? 'bg-primary'}} text-white mb-4">
        <div class="card-body">{{$name ?? '...'}}</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="{{$url ?? url('/')}}">{{$view ?? 'View Details'}}</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>