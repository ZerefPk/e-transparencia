@section('title')
    | Atos Normativos - {{$typeNormativeAct->type}}
@stop
@section('meta-description')

    <meta name="description" content="{{ $typeNormativeAct->type }}">

@stop
<div>
    <div class="container">
        <h2 class="text-uppercase">Atos Normativos</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">Atos Normativos
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$typeNormativeAct->type}}</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h5 class="text-primary text-uppercase">
                    {{$typeNormativeAct->type}}
                </h5>
            </div>
            <div class="p-2">
                <a href="{{route('site.normativeact.advancedQuery')}}" class="text-uppercase btn hover border">
                    Consulta Avançada<i class="fa fa-arrow-alt-circle-right"></i>
                </a>
            </div>

        </div>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Ano:</label>
                            <select class="form-control" style="width: 100%;" name="ano" wire:model="a">
                                <option selected value="">Todos</option>
                                @foreach ($years as $year )
                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-7">

                        <div class="form-group">
                            <label>Ementa: </label>
                            <input class="form-control" type="text" placeholder="Ementa" wire:model="e">

                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Limpar:</label>
                            <button type="button" class="btn btn-primary" style="width: 100%;" wire:click="refreshQuery">
                                <i class="fa fa-broom"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($normativesActs->count() > 0)
            <div class="my-2">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center align-middle" scope="col">{{$typeNormativeAct->type}}</th>
                                <th class="text-center align-middle" scope="col">Ementa</th>
                                <th class="text-center align-middle" scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normativesActs as $normativeAct)
                                <tr>

                                    <td class="text-center align-middle">
                                        <strong>{{ $normativeAct->getRealNumber() }}</strong>
                                    </td>
                                    <td class="align-middle text-break text-justify">
                                        {{ $normativeAct->ementa}}
                                    </td>

                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-primary"
                                            href="{{route('site.normativeact.details', $normativeAct)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $normativesActs->links() !!}
            </div>

        @else
            @if (count($listSearch) > 0)
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros para a busca
                                realizada:
                            </h5>
                            <ul class="text-uppercase">
                                @foreach ($listSearch as $search)
                                    <li class="text-break">
                                        <strong>
                                            {{ $search['field'] }}:
                                        </strong>
                                        {{ $search['value'] }}


                                    </li>
                                @endforeach
                            </ul>
                            <button class=" btn btn-primary text-uppercase" wire:click="refreshQuery">
                                <i class="fa fa-arrow-left"></i> voltar</button>
                        </div>

                    </div>

                </div>
            @else
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros de {{$typeNormativeAct->type}}
                            </h5>
                        </div>
                    </div>

                </div>
            @endisset

        @endif
    </div>
</div>


