@section('title', 'Dashboard - Ramificações')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Ramificações</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Ramificações</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Ramificações:
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
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" wire:model="c" placeholder="Razão Social">
                            </td>
                            <td>
                                <input type="number" class="form-control" wire:model="d" placeholder="CNPJ/CPF">
                            </td>

                            <td>
                                <select class="form-control" style="width: 100%;" wire:model="t">
                                    <option value="">Tipo</option>
                                    @foreach ($types as $key => $type )
                                        <option value="{{$key}}"> {{$type}} </option>
                                    @endforeach
                                </select>
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
                        @forelse ($ramifications as $ramification)
                            <tr>
                                <td>
                                    {{ $ramification->id }}
                                </td>
                                <td>
                                    {{ $ramification->cod }}
                                </td>
                                <td>
                                    {{ $ramification->description }}
                                </td>
                                <td>

                                    {{ $types[$ramification->type] }}
                                </td>

                                <td>
                                    {{ $ramification->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary" wire:click="edit({{$ramification->id}})">
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
                {!! $ramifications->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="form-ramification" tabindex="-1" role="dialog" aria-labelledby="form-ramificationLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-ramificationLabel">
                        @if($method)
                        Editar desdobramento
                        @else
                        Novo desdobramento
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
                        {{ Form::label('cod', 'Código:') }}

                        {{ Form::text('cod', null, ['class' => 'form-control', 'placeholder' => 'Código', 'wire:model' => 'cod']) }}
                        @error('cod')
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

                    <div class="row">

                        <div class="col-sm-6">
                            {{ Form::label('type', 'Tipo: ') }}

                            {{ Form::select('type', $types, null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'type', 'row' => '8']) }}
                            @error('type')
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
        $('#form-ramification').modal('show');

    });
    window.addEventListener('close-form', event => {
        $('#form-ramification').modal('hide');
    });

</script>
@stop
