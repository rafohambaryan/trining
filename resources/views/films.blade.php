@extends('layouts.film')
<div class="container">
    <form id="checked_film_form">
        <label for="films_all"></label>
        <select class="form-control form-control-lg" name="film" id="films_all">
            <option disabled selected class="default_selected">Selected film</option>
            @foreach($films as $film)
                <option value="{{$film->id}}">{{$film->name}}</option>
            @endforeach
        </select>
        <div class="films-content">

        </div>
        <table class="costume_table">
            @foreach($lines as $line)
                <tr>
                    <th>{{$line->name}} N {{$line->order}}</th>
                    @foreach($line->counter as $heir)
                        <td data-id="{{$heir->id}}">{{$heir->order}}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </form>

    <div class="d-flex flex-wrap">
        @foreach($films as $film)
            <div class="card m-3" style="width: 14rem;">
                <img
                    src="@if($film->image) {{asset('/images/uploads/'.$film->image)}} @else {{asset('/images/img/default.jpg')}} @endif"
                    class="card-img-top" alt="...">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">{{$film->name}}</h5>
                    <p class="card-text">{{$film->description}}</p>
                    <a href="{{url('/film/'.$film->id)}}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
