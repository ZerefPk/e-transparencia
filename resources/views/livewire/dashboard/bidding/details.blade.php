@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Licitação</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Licitação</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="text-center">{{ $bidding->getRealNumber() }}</h3>

                <p class="text-muted text-center">{{ $bidding->modality->category }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Tipo: </b> <span class="float-right">{{ $bidding->type->category }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Finalidade: </b> <span class="float-right">{{ $bidding->finality->category }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status: </b> <span class="float-right">
                            @if ($bidding->status)
                                Publicado
                            @else
                                Não publicado
                            @endif
                        </span>
                    </li>
                </ul>

                <a href="{{ route('dashboard.bidding.edit', $bidding->id) }}" class="btn btn-primary btn-block"><i
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

                <p class="text-muted">{{ $bidding->localization }}</p>
                <hr>
                <strong><i class="fas fa-calendar mr-1"></i> Data do certame:</strong>

                <p class="text-muted">
                    {{ isset($bidding->event_date) ? date('d/m/Y', strtotime($bidding->event_date)) : '-' }}
                    {{ isset($bidding->event_time) ? date('H:i', strtotime($bidding->event_time)) : '' }}</p>


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
                    <li class="nav-item border-right"><a
                            class="nav-link"
                            href="#documents" data-toggle="tab">Documentos</a></li>
                    @if ($bidding->modality->special_field)
                    <li class="nav-item border-right"><a
                        class="nav-link" href="#additional"
                        data-toggle="tab">Informações do
                        Certame</a></li>
                    @endif

                    <li class="nav-item border-right"><a class="nav-link" href="#item"
                            data-toggle="tab">Itens</a></li>
                    <li class="nav-item border-right"><a class="nav-link" href="#wins"
                            data-toggle="tab">Vencedores</a></li>

                </ul>
            </div>
            <div class="card-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="basicInformation">
                        <div class="row">
                            <div class="col-sm-2">
                                <p>Objeto:</p>
                            </div>
                            <div class="col-sm-10">
                                <div class="text-break text-justify">
                                    {{$bidding->object }}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <p>Informações Orçamentárias:</p>
                            </div>
                            <div class="col-sm-10">
                                {!! $bidding->budget_information !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Valor Estimado:</p>
                            </div>
                            <div class="col-sm-8">
                                R$: {{ number_format($bidding->estimated_value, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Valor Contratados:</p>
                            </div>
                            <div class="col-sm-8">
                                R$: {{ number_format($bidding->contracted_value, 2, ',', '.') }}
                            </div>
                        </div>

                    </div>
                    @livewire('dashboard.bidding.documents', ['bidding' => $bidding])
                    @if ($bidding->modality->special_field)
                        @livewire('dashboard.bidding.additional', ['bidding' => $bidding])
                    @endif
                    @livewire('dashboard.bidding.item', ['bidding' => $bidding])
                    @livewire('dashboard.bidding.bidding-win', ['bidding' => $bidding])
                </div>


            </div>

        </div>

    </div>
</div>



@section('css')

@stop

@section('js')

@stop
