@extends('layouts.app')

@section('title')
| LIC - Outros Links
@stop
@section('meta-description')

<meta name="description" content="Outros Links de licitações">

@stop


@section('container')

  <div class="container">
    <h3 class="text-uppercase">Outros Links </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('site.bidding.index') }}">Licitação</a>
        </li>

        <li class="breadcrumb-item active" aria-current="page">Outros links</li>
      </ol>
    </nav>
    <div class="border-top  border-primary my-1"></div>

  </div>



  <div class="container my-2 text-uppercase">
    <ul>
      <div class="row">

            @foreach ($years as $year)
            <div class="col-sm-2 my-2">
                <li>
                    <a href="{{ route('site.bidding.index', $year) }}" class="btn btn-primary">{{$year->year}}</a>

                </li>
            </div>
            @endforeach

            <div class="col-sm-12 my-4">
                <li> <a href="#" class="btn btn-primary">Versão antiga</a> </li>
            </div>
      </div>

    </ul>
  </div>

@stop

@section('js')

@stop
