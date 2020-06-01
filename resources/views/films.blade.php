@extends('layouts.film')
<div class="container">
    <form id="checked_film_form">
        <label for="films_all"></label>
        <select class="form-control form-control-lg" name="film" id="films_all">
            <option  selected class="default_selected">Selected film</option>
            @foreach($films as $film)
                <option value="{{$film->id}}">{{$film->name}}</option>
            @endforeach
        </select>
        <div class="films-content">

        </div>
    </form>
</div>
