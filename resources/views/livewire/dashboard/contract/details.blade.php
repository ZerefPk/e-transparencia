@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Contratos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Contratos</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="text-center">{{ $contract->getRealNumber() }}</h3>

                <p class="text-muted text-center"></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Tipo: </b> <span class="float-right"></span>
                    </li>
                    <li class="list-group-item">
                        <b>Finalidade: </b> <span class="float-right"></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status: </b> <span class="float-right">
                            @if ($contract->status)
                                Publicado
                            @else
                                Não publicado
                            @endif
                        </span>
                    </li>
                </ul>

                <a href="{{ route('dashboard.contract.edit', $contract->id) }}" class="btn btn-primary btn-block"><i
                        class="fa fa-edit"></i> <b> Editar</b></a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- About Me Box -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <div class="card-body">

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Local:</strong>

                <p class="text-muted">{{ $contract->localization }}</p>
                <hr>
                <strong><i class="fas fa-calendar mr-1"></i> Data do certame:</strong>

                <p class="text-muted">
                    {{ isset($contract->event_date) ? date('d/m/Y', strtotime($contract->event_date)) : '-' }}
                    {{ isset($contract->event_time) ? date('H:i', strtotime($contract->event_time)) : '' }}</p>


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
                            href="#basicInformation" data-toggle="tab">Informações Basicas</a></li>

                </ul>
            </div>
            <div class="card-body">


            </div>

        </div>

    </div>
</div>



@section('css')

@stop

@section('js')

@stop
