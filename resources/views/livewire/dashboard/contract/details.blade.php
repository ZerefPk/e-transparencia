@section('title', 'Dashboard -  Contrato ')

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
                        <b>Objeto: </b>
                        <p class="text-justify text-break">{{$contract->object}}</p>

                    </li>
                    <li class="list-group-item">
                        <b>Fornecedor: </b> <p class="text-justify text-break">
                            {{ $contract->provider->type ? $contract->provider->cnpj : $contract->provider->cpf }} -
                            {{ $contract->provider->corporate_name }}</p>
                    </li>
                    <li class="list-group-item text-capitalize">
                        <b>Situação: </b>
                        {{$contract->situation->category}}
                    </li>
                    <li class="list-group-item">
                        <b>Assunto: </b>
                        {{$contract->subject->category}}
                    </li>
                    <li class="list-group-item">
                        <b>Status: </b>
                        @if ($contract->status)
                            Habilitado
                        @else
                            Desabilitado
                        @endif

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

                <strong><i class="fas fa-coins mr-1"></i> Valor Total do Contrato R$:</strong>

                <p class="text-muted"> {{ number_format($contract->overall_contract_value, 2, ',', '.') }}
                    - Pagamento:{{$contract->formPayment->category}} </p>
                <hr>
                <strong><i class="fas fa-calendar mr-1"></i>Vigência:</strong>

                <p class="text-muted">
                    {{ date('d/m/Y', strtotime($contract->start_validity)) }} até
                    {{date('d/m/Y', strtotime($contract->end_term))}}
                </p>


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
                    @livewire('dashboard.contract.document', ['contract' => $contract])
                    @livewire('dashboard.contract.item', ['contract' => $contract])
                    @livewire('dashboard.contract.additive', ['contract' => $contract])
                    @livewire('dashboard.contract.contract-effort', ['contract' => $contract])
                </div>
            </div>

        </div>

    </div>
</div>



@section('css')

@stop

@section('js')

@stop
