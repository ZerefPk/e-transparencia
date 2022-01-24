@section('title', 'Dashboard - Contas')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Contas</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Contas</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Contas:
            </h3>
            <div class="card-tools">
                <button class="btn btn-primary btn-block" wire:click="create"><i class="fa fa-plus"></i>
                    Nova</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Conta Reduzida</th>
                            <th>Conta Contábil</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" wire:model="r" placeholder="Conta Reduzida">
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="l" placeholder="Conta Contábil">
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="d" placeholder="Descrição">
                            </td>
                            <td>
                                <select class="form-control" style="width: 100%;" wire:model="s">
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
                        @forelse ($accounts as $account)
                            <tr>
                                <td>
                                    {{ $account->id }}
                                </td>
                                <td>
                                    {{ $account->reduced_account }}
                                </td>
                                <td>
                                    {{ $account->ledger_account }}
                                </td>
                                <td>
                                    {{ $account->description }}
                                </td>

                                <td>
                                    {{ $account->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary" wire:click="edit({{$account->id}})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-uppercase">
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
                {!! $accounts->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="form-account" tabindex="-1" role="dialog" aria-labelledby="form-accountLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-accountLabel">
                        @if($method)
                        Editar conta
                        @else
                        Novo conta
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
                    <div class="form-group">
                        {{ Form::label('reduced_account', 'Conta Reduzida:') }}

                        {{ Form::text('reduced_account', null, ['class' => 'form-control', 'placeholder' => 'Conta Reduzida', 'wire:model' => 'reduced_account']) }}
                        @error('reduced_account')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('ledger_account', 'Conta Contábil:') }}

                        {{ Form::text('ledger_account', null, ['class' => 'form-control', 'placeholder' => 'Conta Contábil', 'wire:model' => 'ledger_account']) }}
                        @error('ledger_account')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Descrição:') }}

                        {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Descrição', 'wire:model' => 'description']) }}
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', 'Status: ') }}

                        {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desativado'], null, ['placeholder' => 'selecione',
                        'class' => 'form-control', 'wire:model' => 'status', 'row' => '8']) }}
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
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
        $('#form-account').modal('show');

    });
    window.addEventListener('close-form', event => {
        $('#form-account').modal('hide');
    });

</script>
@stop
