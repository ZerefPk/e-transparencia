@section('title', 'Dashboard -  Ato Normativo ')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Ato Normativos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Ato Normativo</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="text-center text-uppercase">{{$normativeAct->type->type}} {{ $normativeAct->getRealNumber() }}</h3>

                <p class="text-muted text-center"></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Ementa: </b>
                        <p class="text-justify text-break">{{$normativeAct->ementa}}</p>

                    </li>
                    <li class="list-group-item">
                        <b>Alterada: </b>
                        @if ($normativeAct->altered)
                            Sim
                        @else
                            Não
                        @endif

                    </li>
                    <li class="list-group-item">
                        <b>Revogada: </b>
                        @if ($normativeAct->revoked)
                            Sim
                        @else
                            Não
                        @endif

                    </li>
                    <li class="list-group-item">
                        <b>Status: </b>
                        @if ($normativeAct->status)
                            Habilitado
                        @else
                            Desabilitado
                        @endif

                    </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><i
                        class="fa fa-edit"></i> <b> Editar</b></a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- About Me Box -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <div class="card-body">

                <strong class="text-uppercase"><i class="fas fa-calendar mr-1"></i> Data da publicação</strong>

                <p class="text-muted"> {{date('d/m/Y', strtotime($normativeAct->publication_date))}}</p>
                <hr>



            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item border-right"><a
                            class="nav-link active"
                            href="#documents" data-toggle="tab">Documentos Anexados</a>
                    </li>
                    <li class="nav-item border-right"><a class="nav-link" href="#item"
                                data-toggle="tab">Itens</a>
                    </li>
                    <li class="nav-item border-right"><a class="nav-link" href="#additive"
                                data-toggle="tab">Aditivos Contratuais</a>
                    </li>
                    <li class="nav-item border-right"><a class="nav-link" href="#efforts"
                                data-toggle="tab">Empenhos</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <div class="tab-content">

                </div>
            </div>

        </div>

    </div>
</div>



@section('css')

@stop

@section('js')

@stop
