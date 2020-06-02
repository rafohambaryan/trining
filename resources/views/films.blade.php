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
</div>
