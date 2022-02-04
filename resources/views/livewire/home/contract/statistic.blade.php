@section('title')
    | Contratos - Estatísticas
@stop
@section('meta-description')

    <meta name="description" content="Estatísticas">

@stop
<div>
    <div class="container">
        <h2 class="text-uppercase">Contratos</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item" >
                    <a href="{{route('site.contract.index')}}">Contratos</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Estatísticas</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h5 class="text-primary text-uppercase">
                    Estatísticas dos contratos
                </h5>
            </div>
            <div class="p-2">
                <a href="{{route('site.contract.index')}}" class="text-uppercase btn hover border">
                    detalhar <i class="fa fa-arrow-alt-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card" style="height:25%">
            <div class="card-header">
                <h5 class="card-title text-center text-uppercase">
                    Assuntos da Contratação
                </h5>
            </div>
            <div class="card-body">
                {!! $perSubject->render() !!}
            </div>

        </div>
        <div class="card my-3" style="height:25%">
            <div class="card-header">
                <h5 class="card-title text-center text-uppercase">
                    Evolução histórica (Valor Contratado*)
                </h5>
            </div>
            <div class="card-body">
                {!! $valuePerYear->render() !!}
                <p class="text-muted">*Aditivos não considerados</p>
            </div>
        </div>
        <div class="card my-3" style="height:25%">
            <div class="card-header">
                <h5 class="card-title text-center text-uppercase">
                    Valor Por Contrato*
                </h5>
            </div>
            <div class="card-body">
                {!! $valuePerContract->render() !!}
                <p class="text-muted">*Aditivos considerados</p>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script src="{{ url('js/chartjs.js') }}"></script>
@stop
