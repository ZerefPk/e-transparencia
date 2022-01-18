@section('title', 'Dashboard - Contratos')

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
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Contratos:
            </h3>
            <div class="card-tools">
                <button class="btn btn-primary btn-block" wire:click="create"><i class="fa fa-plus"></i>
                    Novo</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Ano</th>
                            <th>Numero</th>
                            <th>Fornecedor</th>

                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td colspan="2">
                                <input type="text" class="form-control" wire:model="q" placeholder="Razão Social">
                            </td>
                            <td >
                                <input type="text" class="form-control" wire:model="q" placeholder="Razão Social">
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="q" placeholder="Razão Social">
                            </td>


                            <td>
                                <select class="form-control" style="width: 100%;" name="s" wire:model="s">
                                    <option value="" selected>Status</option>
                                    <option value="1">Habilitado</option>
                                    <option value="0" > Disabilitado</option>
                                </select>
                            </td>
                            <td>
                                <button wire:click="refreshQuery()" class="btn btn-warning"><i
                                    class="fa fa-broom"></i>
                                </button>
                            </td>
                        </tr>
                        @forelse ($contracts as $contract)
                            <tr>
                                <td>
                                    {{ $contract->id }}
                                </td>
                                <td>
                                    {{ $contract->year }}
                                </td>
                                <td>
                                    {{ $contract->number }}
                                </td>
                                <td>
                                    {{$contract->provider->corporation_name}}
                                    @if ($contract->provider->type)
                                        - {{ $contract->provider->cnpj }}
                                    @else
                                        - {{ $contract->provider->cpf }}
                                    @endif
                                </td>

                                <td>
                                    {{ $contract->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary" wire:click="edit({{$contract->id}})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-uppercase">
                                    não há registro para o filtro de busca aplicado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {!! $contracts->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="form-contract" tabindex="-1" role="dialog" aria-labelledby="form-contractLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-contractLabel">
                        @if($method)
                        Editar Fornecedor
                        @else
                        Novo Fornecedor
                        @endif

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if($method)
                    {!! Form::open(['wire:submit.prevent' => 'update']) !!}
                @else
                    {!! Form::open(['wire:submit.prevent' => 'store']) !!}
                @endif
                <div class="modal-body">


                    <div class="row">
                        <div class="col-sm-8">
                            {{ Form::label('corporate_name', 'Razão Social:') }}

                            {{ Form::text('corporate_name', null, ['class' => 'form-control', 'placeholder' => 'Razão Social', 'wire:model' => 'corporate_name']) }}
                            @error('corporate_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('type', 'Tipo [PF/PJ]: ') }}

                            {{ Form::select('type', ['1' => 'Pessoa Jurídica', '0' => 'Pessoa Fisíca'], null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'type', 'row' => '8']) }}
                            @error('type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        @if(isset($type) && $type)
                            <div class="col-sm-5">
                                {{ Form::label('fantasy_name', 'Nome Fantasia:') }}

                                {{ Form::text('fantasy_name', null, ['class' => 'form-control', 'placeholder' => 'Nome Fantasia', 'wire:model' => 'fantasy_name']) }}
                                @error('fantasy_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                {{ Form::label('cnpj', 'CNPJ:') }}

                                {{ Form::text('cnpj', null, ['class' => 'form-control', 'placeholder' => 'CNPJ', 'wire:model' => 'cnpj']) }}
                                @error('cnpj')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                {{ Form::label('headquarters', 'Matriz:') }}

                                {{ Form::select('headquarters', ['1' => 'Sim', '0' => 'Não'], null, ['placeholder' => 'selecione',
                                'class' => 'form-control', 'wire:model' => 'headquarters', 'row' => '8']) }}
                                @error('headquarters')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif(isset($type) && !$type)
                            <div class="col-sm-6">
                                {{ Form::label('first_digit', 'Primeiros Digitos CPF:') }}

                                {{ Form::text('first_digit', null, ['class' => 'form-control', 'placeholder' => '000', 'wire:model' => 'first_digit']) }}
                                @error('first_digit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                {{ Form::label('verify_digit', 'Digito verificador CPF:') }}

                                {{ Form::text('verify_digit', null, ['class' => 'form-control', 'placeholder' => '00', 'wire:model' => 'verify_digit']) }}
                                @error('verify_digit')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="col-sm-6">
                            {{ Form::label('mei_company', 'Fornecedor MEI: ') }}

                            {{ Form::select('mei_company', ['1' => 'Sim', '0' => 'Não'], null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'mei_company', 'row' => '8']) }}
                            @error('mei_company')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('status', 'Status: ') }}

                            {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desativado'], null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'status', 'row' => '8']) }}
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-sm-12">
                            {{ Form::label('legal_nature', 'Natureza Jurídica: ') }}

                            {{ Form::text('legal_nature', null, ['placeholder' => 'Natureza Jurídica', 'class' => 'form-control', 'wire:model' => 'legal_nature']) }}
                            @error('legal_nature')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>

@section('css')

@stop

@section('js')
<script>
    window.addEventListener('open-form', event => {
        $('#form-contract').modal('show');

    });
    window.addEventListener('close-form', event => {
        $('#form-contract').modal('hide');
    });

</script>
@stop
