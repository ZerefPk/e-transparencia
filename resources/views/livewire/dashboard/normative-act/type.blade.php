@section('title', 'Dashboard - Tipos de Atos Normativos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Tipos de Atos Normativos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Tipos de Atos Normativos</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Tipos de Atos Normativos:
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
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" wire:model="t" placeholder="Tipo">
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
                        @forelse ($typesNomativeActs as $typeNomativeAct)
                            <tr>
                                <td>
                                    {{ $typeNomativeAct->id }}
                                </td>
                                <td>
                                    {{ $typeNomativeAct->type }}
                                </td>

                                <td>
                                    {{ $typeNomativeAct->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary" wire:click="edit({{$typeNomativeAct->id}})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-uppercase">
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
                {!! $typesNomativeActs->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="form-type" tabindex="-1" role="dialog" aria-labelledby="form-typeLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-typeLabel">
                        @if($method)
                        Editar Tipo de Atos Normativo
                        @else
                        Novo Tipo de Atos Normativo
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
                            {{ Form::label('type', 'Tipo:') }}

                            {{ Form::text('type', null, ['class' => 'form-control', 'placeholder' => 'Tipo', 'wire:model' => 'type']) }}
                            @error('type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('status', 'Status: ') }}

                            {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desativado'], null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'status', 'row' => '8']) }}
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Descrição:') }}

                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Tipo', 'wire:model' => 'description', 'rows' => '4']) }}
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('can_altered', 'Pode Alterar: ') }}

                        <div>
                            <select class="form-control" wire:model="can_altered" style="width: 100%" multiple="multiple">

                                @foreach ($types as $item)
                                    <option value="{{ $item->id }}">{{$item->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('can_altered')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('can_revoked', 'Pode revogar: ') }}


                        <div>
                            <select class="form-control" wire:model="can_revoked" name="can_revoked[]" multiple="multiple">

                                @foreach ($types as $item)
                                    <option value="{{ $item->id }}">{{$item->type}}</option>
                                @endforeach
                            </select>
                        </div>

                        @error('can_revoked')
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
    <link rel="stylesheet" href="{{ url('css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@endsection
@push('js')
    <script src="{{ url('js/select2.min.js') }}"></script>


<script>

    window.addEventListener('open-form', event => {
        $('#form-type').modal('show');

    });
    window.addEventListener('close-form', event => {
        $('#form-type').modal('hide');
    });

</script>
@endpush
