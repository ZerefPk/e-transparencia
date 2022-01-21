@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Contrato: Novo</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('dashboard.contract.index') }}">Contratos</a></li>
                <li class="breadcrumb-item active">Novo</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    {!! Form::open(['wire:submit.prevent' => 'store']) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Novo Contrato</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col">
                    <div class="form-group">
                        {{ Form::label('year', 'Ano: ') }}

                        {{ Form::select('year', $years, null, ['placeholder' => 'Selecione um ano', 'class' => 'form-control', 'wire:model' => 'year']) }}
                        @error('year')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('number', 'Numero do Contrato:') }}

                        {{ Form::text('number', null, ['class' => 'form-control', 'placeholder' => 'Ex. 000001', 'wire:model' => 'number']) }}
                        @error('number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">

                {{ Form::label('object', 'Objeto:') }}

                {{Form::textarea('object', null, ['class' => 'form-control', 'id' => 'object', 'placeholder' => 'Ex. Aquisição de...', 'rows' => '4', 'wire:model' => 'object']) }}

                @error('object')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
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
                        <div wire:ignore>
                            <label for="provider-select">Fornecedor: </label>
                            <select class="form-control" id="provider-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->type ? $provider->cnpj : $provider->cpf }} -
                                        {{ $provider->corporate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('provider_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('form_contract_id', 'Situação do Contrato: ') }}

                        {{ Form::select('form_contract_id', $formContracts, null, ['placeholder' => 'Selecione', 'class' => 'form-control', 'wire:model' => 'form_contract_id']) }}
                        @error('form_contract_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('situation_id', 'Forma de Contração: ') }}

                        {{ Form::select('situation_id', $situations, null, ['placeholder' => 'Selecione', 'class' => 'form-control', 'wire:model' => 'situation_id']) }}
                        @error('situation_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="provider-select">Histórico da Contratação: </label>
                            <select class="form-control" id="bidding-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($biddings as $bidding)
                                    <option value="{{ $bidding->id }}">{{$bidding->getRealNumber()}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-goup">
                        {{ Form::label('overall_contract_value', 'Valor Total do contrato R$:') }}

                        {{ Form::number('overall_contract_value', null,
                        ['class' => 'form-control', 'placeholder' => 'Valor Total do contrato',
                        'wire:model' => 'overall_contract_value','step' => '.01']) }}
                        @error('overall_contract_value')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-goup">
                        <div class="form-group">

                            {{ Form::label('form_payment_id', 'Forma de Pagamento:') }}

                            {{ Form::select('form_payment_id', $formPayments, null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model'=>'form_payment_id']) }}
                            @error('form_payment_id')
                              <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        {{Form::label('signature_date', 'Data da Assinatura:')}}
                        {{Form::date('signature_date', null, ['class'=>'form-control', 'wire:model' => 'signature_date'])}}
                        @error('signature_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        {{Form::label('start__validity', 'Inicio da Vigência:')}}
                        {{Form::date('start__validity', null, ['class'=>'form-control', 'wire:model' => 'start__validity'])}}
                        @error('start__validity')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{Form::label('end_term', 'Fim da Vigência :')}}
                        {{Form::date('end_term', null, ['class'=>'form-control', 'wire:model' => 'end_term'])}}
                        @error('end_term')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">

                        {{ Form::label('contract_tax', 'Fiscal do Contrato:') }}

                        {{ Form::text('contract_tax', null, ['class' => 'form-control', 'placeholder' => 'Fiscal do Contrato', 'wire:model' => 'contract_tax']) }}
                        @error('contract_tax')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">

                        {{ Form::label('contract_manager', 'Gestor do Contrato:') }}

                        {{ Form::text('contract_manager', null, ['class' => 'form-control', 'placeholder' => 'Gestor do Contrato', 'wire:model' => 'contract_manager']) }}
                        @error('contract_manager')
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
    </script>
    <script>
        $('#bidding-select').select2({
            theme: 'bootstrap4',
        })
        $('#bidding-select').on('change', function(e) {
                var data = $('#bidding-select').select2("val");
                @this.set('bidding_id', data);
            });
    </script>

@endpush
