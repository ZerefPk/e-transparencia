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
        <div class="container my-2">
            <div class="row">
                <div class="col-sm-3">

                    <form action="" method="get">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Buscar:</h5>

                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" placeholder="Processo ou Objeto" name="q">
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Modalidade:</label>
                                    <select class="form-control" style="width: 100%;" name="modalidade">
                                        <option selected disabled>Modalidade</option>
                                        @foreach ($categories->where('type', 'bidding_modality') as $modality)
                                            <option value="{{ $modality->slug }}">{{ $modality->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Situação:</label>
                                    <select class="form-control" style="width: 100%;" name="situacao">
                                        <option selected disabled>Situação</option>
                                        @foreach ($categories->where('type', 'bidding_situation') as $situation)
                                            <option value="{{ $situation->slug }}">{{ $situation->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tipo: </label>
                                    <select class="form-control" style="width: 100%;" name="tipo">
                                        <option selected disabled>Tipo de licitação</option>
                                        @foreach ($categories->where('type', 'bidding_type') as $type)
                                            <option value="{{ $type->slug }}">{{ $type->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-9">
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
            </div>

        @else
            @isset($listSearch)
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
                            <a class=" btn btn-primary text-uppercase" href="{{ route('site.bidding.index', $yearActive) }}">
                                <i class="fa fa-arrow-left"></i> voltar</a>
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
