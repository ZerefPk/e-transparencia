@section('title')
    | Licitações {{ $yearActive->year }}
@stop
@section('meta-description')

    <meta name="description" content="Licitações {{ $yearActive->year }}">

@stop



<div>
    <div class="container">
        @include('home-components.bidding.header', [$years, $yearActive])
    </div>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">Licitações {{ $yearActive->year }}</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
    </div>


    @if ($biddings->count() > 0)
        <div class="container my-2 ">
            <div class="d-flex justify-content-between">
                <div class="p-2">
                    <h5 class="text-primary text-uppercase">
                        Visão geral das Licitações de
                        {{ $yearActive->year }}
                    </h5>
                </div>
                <div class="p-2">
                    <a href="#"
                        class="text-uppercase btn hover border">
                        Ver em graficos <i class="fa fa-arrow-alt-circle-right"></i>
                    </a>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">

                            <div class="form-group">
                                <label>Buscar:</label>
                                <input type="text" class="form-control" style="width: 100%;" placeholder="Processo ou Objeto" name="q" wire:model="q">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                             <label>Modalidade:</label>
                             <select class="form-control" style="width: 100%;" name="modalidade" wire:model="modalidade">
                                 <option selected disabled>Modalidade</option>
                                 @foreach ($categories->where('type', 'bidding_modality') as $modality)
                                     <option value="{{ $modality->slug }}">{{ $modality->category }}</option>
                                 @endforeach
                             </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                             <label>Tipo:</label>
                             <select class="form-control" style="width: 100%;" name="tipo" wire:model="tipo">
                                 <option selected disabled>Tipo</option>
                                 @foreach ($categories->where('type', 'bidding_type') as $modality)
                                     <option value="{{ $modality->slug }}">{{ $modality->category }}</option>
                                 @endforeach
                             </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Situação:</label>
                                <select class="form-control" name="situacao" wire:model="situacao">
                                    <option selected disabled>Situação</option>
                                    @foreach ($categories->where('type', 'bidding_situation') as $situation)
                                        <option value="{{ $situation->slug }}">{{ $situation->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-sm-2" >
                            <div class="form-group">
                                <label>Limpar:</label>
                                <button type="button" class="btn btn-primary" style="width: 100%;" wire:click="resetAttr">
                                    <i class="fa fa-broom"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center align-middle" scope="col">Nº do Processo</th>
                                <th class="text-center align-middle" scope="col">Objeto</th>
                                <th class="text-center align-middle" scope="col">Modalidade</th>
                                <th class="text-center align-middle" scope="col">Situação</th>
                                <th class="text-center align-middle" scope="col">Data do Certame</th>
                                <th class="text-center align-middle" scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biddings as $bidding)
                                <tr>
                                    <td class="text-center align-middle">
                                        <strong>{{ $bidding->year . '/' . $bidding->number }}</strong>
                                    </td>
                                    <td class="text-break text-justify">
                                        {{ strip_tags(html_entity_decode($bidding->object, ENT_COMPAT, 'UTF-8')) }}
                                    </td>
                                    <td class="text-center align-middle">{{ $bidding->modality->category }}</td>
                                    <td class="text-center align-middle">{{ $bidding->situation->category }}</td>
                                    <td class="text-center align-middle">
                                        {{ isset($bidding->event_date) ? date('d/m/Y', strtotime($bidding->event_date)) : '-' }}
                                        {{ isset($bidding->event_time) ? date('H:i', strtotime($bidding->event_time)) : '' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('site.bidding.index', $bidding) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $biddings->links() !!}
            </div>

        @else
            @if(count($listSearch) > 0)
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros de licitações no ano de {{ $yearActive->year }} Para a busca realizada:
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
                            <button class=" btn btn-primary text-uppercase" wire:click="resetAttr">
                                <i class="fa fa-arrow-left"></i> voltar</button>
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
            @endisset

    @endif
</div>
