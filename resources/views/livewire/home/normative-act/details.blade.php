@section('title')
    | Atos Normativos - {{$normativeAct->type->type}} - {{ $normativeAct->getRealNumber() }}
@stop
@section('meta-description')

    <meta name="description" content="{{ $normativeAct->ementa }}">

@stop

<div>
    <div class="container">
        <h3 class="text-uppercase">{{$normativeAct->type->type}}: {{ $normativeAct->getRealNumber() }} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('site.normativeact.index', $normativeAct->type) }}"> {{$normativeAct->type->plural}} </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $normativeAct->getRealNumber() }}
                </li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-4"></div>
    </div>
    <div class="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0 text-uppercase">{{$normativeAct->type->type}} nº {{ $normativeAct->number }},
                        de {{date( 'd' ,strtotime($normativeAct->publication_date))}}
                        de {{$mes_extenso[date( 'M' ,strtotime($normativeAct->publication_date))]}}
                        de {{date( 'Y' ,strtotime($normativeAct->publication_date))}}

                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="table-primary">Numero da {{$normativeAct->type->type}}:</th>
                                <td>{{ $normativeAct->number }}</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Ementa:</th>
                                <td>{{ $normativeAct->ementa }}</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Descrição:</th>
                                <td>{{ $normativeAct->description }}</td>
                            </tr>
                            @if ($normativeAct->type->journaling)

                                <tr>
                                    <th class="table-primary">Data da Publicação em Diário Oficial</th>
                                    <td>{{ ($normativeAct->date_journal_publication) ? date('d/m/Y', strtotime($normativeAct->date_journal_publication)) : '-' }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th class="table-primary">Resolução em vigor:</th>
                                <td>{{ $normativeAct->status == 1 ? 'SIM' : 'NÃO' }}</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Resolução foi alterada:</th>
                                <td>{{ $normativeAct->altered == 1 ? 'SIM' : 'NÃO' }}</td>
                            </tr>
                            <tr>
                                <th class="table-primary">Resolução foi revogada:</th>
                                <td>{{ $normativeAct->revoked == 1 ? 'SIM' : 'NÃO' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if (isset($normativeAct->doc))
                        <p>Para obter o arquivo completo da resolução em formato DOC, clique no link a seguir:
                            <a href="{{ route('download', ['doc', 'normativeAct' => $normativeAct]) }}" target="_blank"
                                class="btn btn-primary btn-xs">
                                Download&nbsp;<i class="fa fa-file-word"></i>
                            </a>
                        </p>
                    @endif
                    @if (isset($normativeAct->pdf))
                        <p>Para obter o arquivo completo da resolução em formato PDF, clique no link a seguir:
                            <a href="{{ route('download', ['pdf', 'normativeAct' => $normativeAct]) }}" target="_blank"
                                class="btn btn-primary btn-xs">
                                Download&nbsp;<i class="fa fa-file-pdf"></i>
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Essa resolução revogou a(s) seguinte(s) resolução(ões):</td>
                        </tr>
                    </thead>
                    <tbody>
                       {{-- @foreach ($normativeAct->revokes as $p)
                            @foreach ($p->legislations as $c)
                                <tr>
                                    <td>
                                        <a href="{{ route('details', $c->id) }}">
                                            {{ $c->year }}/{{ $c->resolution }} - {{ $c->ementa }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach--}}
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Essa resolução foi revogada pela seguinte(s) resolução(ões):</td>
                        </tr>
                    </thead>
                    <tbody>

                        {{--@if ($normativeAct->revoke)
                            <tr>
                                <td>
                                    <a href="{{ route('details', $normativeAct->revoke->revoked->id) }}">
                                        {{ $normativeAct->revoke->revoked->year }}/{{ $data->revoke->revoked->resolution }} -
                                        {{ $data->revoke->revoked->ementa }}
                                    </a>
                                </td>
                            </tr>
                        @endif--}}

                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Essa resolução alterou a(s) seguinte(s) resolução(ões):</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{--
                        @foreach ($data->alters as $p)
                            @foreach ($p->legislations as $c)
                                <tr>
                                    <td>
                                        <a href="{{ route('details', $c->id) }}">
                                            {{ $c->year }}/{{ $c->resolution }} - {{ $c->ementa }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        --}}
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Essa resolução foi alterada pela seguinte(s) resolução(ões):</td>
                        </tr>
                    </thead>
                    <tbody>
                        {{--
                        @foreach ($data->alter as $p)
                            @foreach ($p->parents as $c)
                                <tr>
                                    <td>
                                        <a href="{{ route('details', $c->id) }}">
                                            {{ $c->year }}/{{ $c->resolution }} - {{ $c->ementa }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
