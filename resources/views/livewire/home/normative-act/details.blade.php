@section('title')
    | Atos Normativos - {{ $normativeAct->type->type }} - {{ $normativeAct->getRealNumber() }}
@stop
@section('meta-description')

    <meta name="description" content="{{ $normativeAct->ementa }}">

@stop

<div>
    <div class="container">
        <h3 class="text-uppercase">{{ $normativeAct->type->type }}: {{ $normativeAct->getRealNumber() }} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('site.normativeact.index', $normativeAct->type) }}">
                        {{ $normativeAct->type->plural }} </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $normativeAct->getRealNumber() }}
                </li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-4"></div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 text-uppercase">{{ $normativeAct->type->type }} nº
                    {{ $normativeAct->number }},
                    de {{ date('d', strtotime($normativeAct->publication_date)) }}
                    de {{ $mes_extenso[date('M', strtotime($normativeAct->publication_date))] }}
                    de {{ date('Y', strtotime($normativeAct->publication_date)) }}

                </h5>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="basicInformation">

                        <div class="col">
                            <strong class="text-uppercase"> Ementa:</strong>
                            <p class="text-break text-justify">
                                {{ $normativeAct->ementa }}
                            </p>
                        </div>


                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Em Vigor: </strong>
                                <p>
                                    {{ $normativeAct->active == 1 ? 'SIM' : 'NÃO' }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Alterada:
                                </strong>
                                <p>
                                    {{ $normativeAct->altered == 1 ? 'SIM' : 'NÃO' }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Revogada
                                </strong>
                                <p>
                                    {{ $normativeAct->revoked == 1 ? 'SIM' : 'NÃO' }}
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                @if (isset($normativeAct->doc))
                    <p>Para obter o arquivo completo em formato DOC, clique no link a seguir:
                        <a href="{{ route('download', ['doc', 'normativeAct' => $normativeAct]) }}" target="_blank"
                            class="btn btn-primary btn-xs">
                            Download&nbsp;<i class="fa fa-file-word"></i>
                        </a>
                    </p>
                @endif
                @if (isset($normativeAct->pdf))
                    <p>Para obter o arquivo completo em formato PDF, clique no link a seguir:
                        <a href="{{ route('download', ['pdf', 'normativeAct' => $normativeAct]) }}" target="_blank"
                            class="btn btn-primary btn-xs">
                            Download&nbsp;<i class="fa fa-file-pdf"></i>
                        </a>
                    </p>
                @endif
            </div>
        </div>
        @if (count($normativeAct->alter))

            <div class="card my-3">
                <div class="card-header">
                    <h5 class="card-title text-uppercase">Esta {{ $normativeAct->type->type }} foi alterada pelo(s)
                        seguinte(s) Atos:</h5>
                </div>
                <div class="card-body">
                    @foreach ($normativeAct->alter as $p)
                        <li class="list-group-item">

                            <a class="text-uppercase"
                                href="{{ route('site.normativeact.details', $p->parent) }}">
                                {{ $p->parent->type->type }} {{ $p->parent->number }},
                                de {{ date('d', strtotime($p->parent->publication_date)) }}
                                de {{ $mes_extenso[date('M', strtotime($p->parent->publication_date))] }}
                                de {{ date('Y', strtotime($p->parent->publication_date)) }}
                            </a>

                        </li>

                    @endforeach
                </div>
            </div>
        @endif
        @if ($normativeAct->revoke)
            <div class="card my-3">
                <div class="card-header">
                    <h5 class="card-title text-uppercase">Esta {{ $normativeAct->type->type }} foi revogada pela
                        seguinte ato:</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">

                        <li class="list-group-item">

                            <a class="text-uppercase"
                                href="{{ route('site.normativeact.details', $normativeAct->revoke->parent) }}">
                                {{ $normativeAct->revoke->parent->type->type }} {{ $normativeAct->revoke->parent->number }},
                                de {{ date('d', strtotime($normativeAct->revoke->parent->publication_date)) }}
                                de {{ $mes_extenso[date('M', strtotime($normativeAct->revoke->parent->publication_date))] }}
                                de {{ date('Y', strtotime($normativeAct->revoke->parent->publication_date)) }}
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        @endif
        @if (count($normativeAct->alters))
            <div class="card my-3">
                <div class="card-header">
                    <h5 class="card-title text-uppercase">Esta {{ $normativeAct->type->type }} alterou a(s)
                        seguinte(s)
                        atos:</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">


                        @foreach ($normativeAct->alters as $p)
                            <li class="list-group-item">

                                <a class="text-uppercase"
                                    href="{{ route('site.normativeact.details', $p->normativeAct) }}">
                                    {{ $p->normativeAct->type->type }} {{ $p->normativeAct->number }},
                                    de {{ date('d', strtotime($p->normativeAct->publication_date)) }}
                                    de {{ $mes_extenso[date('M', strtotime($p->normativeAct->publication_date))] }}
                                    de {{ date('Y', strtotime($p->normativeAct->publication_date)) }}
                                </a>

                            </li>


                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (count($normativeAct->revokes))
            <div class="card my-3">
                <div class="card-header">
                    <h5 class="card-title text-uppercase">Esta {{ $normativeAct->type->type }} revogou a(s)
                        seguinte(s) Atos:</h5>
                </div>
                <div class="card-body">
                    @foreach ($normativeAct->revokes as $p)
                        <li class="list-group-item">

                            <a class="text-uppercase"
                                href="{{ route('site.normativeact.details', $p->normativeAct) }}">
                                {{ $p->normativeAct->type->type }} {{ $p->normativeAct->number }},
                                de {{ date('d', strtotime($p->normativeAct->publication_date)) }}
                                de {{ $mes_extenso[date('M', strtotime($p->normativeAct->publication_date))] }}
                                de {{ date('Y', strtotime($p->normativeAct->publication_date)) }}
                            </a>

                        </li>

                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
