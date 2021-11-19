@extends('layouts.app')
@section('title')
| LIC - Analise Gráfica {{ $yearActive->year }} 
@stop
@section('meta-description')

<meta name="description" content="Analise Gráfica das Licitações de {{ $yearActive->year }}">

@stop

@section('container')
  <div class="container">
    @include('site.bidding.header')
  </div>
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('site.bidding.index', $yearActive) }}">Licitações {{ $yearActive->year }}</a>
        </li>

        <li class="breadcrumb-item active" aria-current="page">Analise gráfica</li>
      </ol>
    </nav>
    <div class="border-top  border-primary my-1"></div>
    <div class="d-flex justify-content-between">
      <div class="p-2">
        <h5 class="text-primary text-uppercase">
          Analise gráfica das Licitações de
          {{ $yearActive->year }}
        </h5>
      </div>
      <div class="p-2">
        <a href="{{ route('site.bidding.index', $yearActive) }}" class="text-uppercase btn hover border">
          Detalhar <i class="fa fa-arrow-alt-circle-right"></i>
        </a>

      </div>
    </div>
  </div>


  @if ($yearActive->biddings->count() > 0)
    <div class="container my-2">

      <div class="row">
        <div class="col-sm-6" style=" height:100% ">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title text-center text-uppercase">
                Licitações por modalidades em {{ $yearActive->year }}
              </h5>
            </div>
            <div class="card-body">
              {!! $modalitiesYearCharts->render() !!}
            </div>

          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title text-center text-uppercase">
                Gastos por modalidades em {{ $yearActive->year }}
              </h5>
            </div>
            <div class="card-body">
              {!! $valuecontractedCharts->render() !!}
            </div>

          </div>
          <div class="card my-3">
            <div class="card-header">
              <h5 class="card-title text-center text-uppercase">
                Evolução de Dispensa x Inexegibilidade
              </h5>
            </div>
            <div class="card-body">
              {!! $evolutionAB->render() !!}
            </div>

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="card my-3">
            <div class="card-header">
              <h5 class="card-title text-center text-uppercase">
                Finalidade da Licitação em {{ $yearActive->year }}
              </h5>
            </div>
            <div class="card-body">
              {!! $quantityByYearFinality->render() !!}
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card my-3">
            <div class="card-header">
              <h5 class="card-title text-center text-uppercase">
                Valor por Finalidade da Licitação em {{ $yearActive->year }}
              </h5>
            </div>
            <div class="card-body">
              {!! $valueByYearFinality->render() !!}
            </div>
          </div>

        </div>
      </div>
      
      <div class="card my-4">
        <div class="card-header">
          <h5 class="card-title text-center text-uppercase">
            Evolução do ultimos anos
          </h5>
        </div>
        <div class="card-body">
          {!! $evolutionYear->render() !!}
        </div>
      </div>
    </div>

  @else

    <div class="container">
      <div class="card my-5">
        <div class="card-body">
          <h5 class="text-uppercase">
            Não há registros de licitações para o ano de {{ $yearActive->year }}
          </h5>
        </div>
      </div>

    </div>
  @endif
@stop

@section('js')

  <script src="{{ asset('js/chartjs.js') }}"></script>
@stop
