@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Empenho: Editar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('dashboard.contract.index') }}">Empenhos</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    {!! Form::open(['wire:submit.prevent' => 'store']) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Empenho</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-sm-2">
                    <div class="form-group">
                        {{ Form::label('year', 'Ano: ') }}

                        {{ Form::select('year', $years, null, ['placeholder' => 'Selecione um ano', 'class' => 'form-control', 'wire:model' => 'year']) }}
                        @error('year')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        {{ Form::label('number', 'Número do empenho:') }}

                        {{ Form::text('number', null, ['class' => 'form-control',
                        'placeholder' => 'Número do empenho', 'wire:model' => 'number']) }}
                        @error('number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        {{ Form::label('reservation_number', 'Número da reserva:') }}

                        {{ Form::text('reservation_number', null, ['class' => 'form-control',
                        'placeholder' => 'Número da reserva', 'wire:model' => 'reservation_number']) }}
                        @error('reservation_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">

                        {{ Form::label('type', 'Tipo:') }}

                        {{ Form::select('type', $types,null, ['class' => 'form-control', 'placeholder' => 'Selecione', 'wire:model' => 'type']) }}
                        @error('type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {{ Form::label('date_effort', 'Data do empenho:') }}

                        {{ Form::date('date_effort', null, ['class' => 'form-control',  'wire:model' => 'date_effort']) }}
                        @error('date_effort')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">

                {{ Form::label('description', 'Descrição:') }}

                {{Form::textarea('description', null, ['class' => 'form-control',
                'id' => 'description', 'placeholder' => 'Descrição', 'rows' => '4',
                'wire:model' => 'description']) }}

                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="provider-select">Beneficiário: </label>
                            <select class="form-control" id="provider-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}"
                                        @if ($provider->id == $effort->provider_id)
                                        selected
                                        @endif
                                    >{{ $provider->type ? $provider->cnpj : $provider->cpf }} -
                                        {{ $provider->corporate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('provider_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div>
                            <label for="contract-select">Contrato: </label>
                            <select class="form-control" id="contract-select" style="width: 100%" wire:model="contract_id">
                                <option selected>Selecione</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{$contract->getRealNumber()}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    {{ Form::label('total_value', 'Valor do empenho R$:') }}

                    {{Form::number('total_value', null, ['class' => 'form-control',
                    'id' => 'total_value', 'placeholder' => 'Valor do empenho',
                     'wire:model' => 'total_value', 'step' => '.01']) }}

                    @error('total_value')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
                <div class="col">
                    {{ Form::label('number_installments', 'Parcelas:') }}

                    {{Form::number('number_installments', null, ['class' => 'form-control',
                     'placeholder' => 'Parcelas', 'wire:model' => 'number_installments']) }}

                    @error('number_installments')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>

                <div class="col">
                    {{ Form::label('unitary_value', 'Valor da parcela R$:') }}

                    {{Form::number('unitary_value', null, ['class' => 'form-control',
                     'id' => 'unitary_value', 'placeholder' => 'Valor da parcela',
                     'wire:model' => 'unitary_value', 'step' => '.01']) }}

                    @error('unitary_value')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
                <div class="col">
                    {{ Form::label('adjusted_value', 'Ajustes R$:') }}

                    {{Form::number('adjusted_value', null, ['class' => 'form-control', 'id' => 'adjusted_value',
                    'placeholder' => 'Ajustes', 'wire:model' => 'adjusted_value', 'step' => '.01']) }}

                    @error('adjusted_value')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
            </div>
            <div class="row">


                <div class="col">
                    {{ Form::label('executed_installments', 'Parcelas executadas:') }}

                    {{Form::number('executed_installments', null, ['class' => 'form-control', 'id' => 'executed_installments',
                     'placeholder' => 'Parcelas executadas:', 'wire:model' => 'executed_installments']) }}

                    @error('executed_installments')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
                <div class="col">
                    {{ Form::label('total_executed', 'Total executado R$:') }}

                    {{Form::number('total_executed', null, ['class' => 'form-control',
                    'id' => 'total_executed', 'placeholder' => 'Total executado',
                     'wire:model' => 'total_executed', 'step' => '.01']) }}

                    @error('total_executed')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
                <div class="col">
                    {{ Form::label('total_to_executed', 'Total a executar R$:') }}

                    {{Form::number('total_to_executed', null, ['class' => 'form-control',
                    'id' => 'total_to_executed', 'placeholder' => 'Total executado',
                     'wire:model' => 'total_to_executed', 'step' => '.01']) }}

                    @error('total_to_executed')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
                <div class="col">
                    {{ Form::label('current_value', 'Total Atual:') }}

                    {{Form::number('current_value', null, ['class' => 'form-control',
                    'id' => 'current_value', 'placeholder' => 'Total executado',
                     'wire:model' => 'current_value', 'step' => '.01']) }}

                    @error('current_value')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="project-select">Projeto: </label>
                            <select class="form-control" id="project-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        @if ($project->id == $effort->project_id)
                                            selected
                                        @endif
                                        >{{$project->getName()}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('project_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <div>
                            <label for="subProject-select">SubProjeto: </label>
                            <select class="form-control" id="subProject-select" style="width: 100%" wire:model='subproject_id'>
                                <option selected>Selecione</option>
                                @foreach ($subProjects as $subProject)
                                    <option value="{{ $subProject->id }}"
                                        @if ($subProject->id == $effort->subproject_id)
                                        selected
                                        @endif
                                    >{{$subProject->getName()}}</option>
                                @endforeach
                            </select>
                            @error('subproject_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="account-select">Conta: </label>
                            <select class="form-control" id="account-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}"
                                        @if ($account->id == $effort->account_id)
                                        selected
                                        @endif
                                    >{{$account->getName()}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('budget_account_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="action-select">Ação: </label>
                            <select class="form-control" id="action-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action->id }}"
                                        @if ($action->id == $effort->action_id)
                                        selected
                                        @endif
                                        >{{$action->getName()}}</option>
                                @endforeach
                            </select>
                        </div>

                        @error('action_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="modality-select">Modalidade: </label>
                            <select class="form-control" id="modality-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($modalities as $modality)
                                    <option value="{{ $modality->id }}"
                                        @if ($modality->id == $effort->modality_id)
                                        selected
                                        @endif
                                    >{{$modality->getName()}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('modality_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    {{Form::label('complement', 'Complemento')}}
                    {{ Form::text('complement', null, ['class' => 'form-control',
                    'placeholder' => 'Complemento', 'wire:model' => 'complement']) }}
                    @error('complement')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('process_number', 'Processo Numero:') }}

                        {{ Form::text('process_number', null, ['class' => 'form-control', 'placeholder' => 'Ex: ADM 2020/0001', 'wire:model' => 'process_number']) }}
                        @error('process_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('finished', 'Finalizado:') }}

                        {{ Form::select('finished', ['1' => 'Sim', '0' => 'Não'],null, ['class' => 'form-control', 'placeholder' => 'Selecione', 'wire:model' => 'finished']) }}
                        @error('finished')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">

                        {{ Form::label('status', 'Status:') }}

                        {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desabilitado'],null, ['class' => 'form-control', 'placeholder' => 'Selecione', 'wire:model' => 'status']) }}
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>


        </div>

       <div class="card-footer">
        <a class="btn  btn-secondary" href="{{route('dashboard.contract.index')}}">Cancelar</a>
        {{ Form::submit('Salvar', ['class' => 'btn  btn-success']) }}
       </div>
    </div>

    {!! Form::close() !!}
</div>
@section('css')
<link rel="stylesheet" href="{{url('css/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@stop
@push('js')

    <script src="{{ url('js/select2.min.js') }}"></script>
    <script>
        $('#provider-select').select2({
            theme: 'bootstrap4',
        })
        $('#provider-select').on('change', function(e) {
                var data = $('#provider-select').select2("val");
                @this.set('provider_id', data);
        });
        $('#project-select').select2({
            theme: 'bootstrap4',
        })
        $('#project-select').on('change', function(e) {
                var data = $('#project-select').select2("val");
                @this.set('project_id', data);
        });
        $('#account-select').select2({
            theme: 'bootstrap4',
        })
        $('#account-select').on('change', function(e) {
                var data = $('#account-select').select2("val");
                @this.set('budget_account_id', data);
        });

        $('#action-select').select2({
            theme: 'bootstrap4',
        })
        $('#action-select').on('change', function(e) {
                var data = $('#action-select').select2("val");
                @this.set('action_id', data);
        });
        $('#modality-select').select2({
            theme: 'bootstrap4',
        })
        $('#modality-select').on('change', function(e) {
                var data = $('#modality-select').select2("val");
                @this.set('modality_id', data);
        });
    </script>


@endpush
