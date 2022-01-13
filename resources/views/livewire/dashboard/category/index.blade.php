@section('title', 'Dashboard - Categorias')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Categorias</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Categoria</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Categorias:
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
                            <th>Categoria</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" wire:model="q" placeholder="Categoria">
                            </td>
                            <td>
                                <select class="form-control" style="width: 100%;" name="type" wire:model="type">
                                    <option selected>Tipo</option>

                                    @foreach ($types as $key => $collection)

                                      <optgroup label="{{ $key }}">
                                        @foreach ($collection as $keyType => $type)
                                          <option value="{{ $keyType }}" @if (isset($dataForm['type']) && $keyType == $dataForm['type']) selected @endif>{{ $type }}</option>
                                        @endforeach
                                      </optgroup>
                                    @endforeach
                                  </select>
                            </td>
                            <td>
                                <select class="form-control" style="width: 100%;" name="status" wire:model="status">
                                    <option selected>Status</option>
                                    <option value="1" @if (isset($dataForm['status']) && 1 == $dataForm['status']) selected @endif>Habilitado</option>
                                    <option value="0" @if (isset($dataForm['status']) && 0 == $dataForm['status']) selected @endif> Disabilitado</option>
                                </select>
                            </td>
                            <td>
                                <button wire:click="resetPage()" class="btn btn-warning"><i
                                    class="fa fa-broom"></i>
                                </button>
                            </td>
                        </tr>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td>
                                    {{ $category->category }}
                                </td>
                                <td>
                                    @foreach ($types as $key => $type)
                                        @foreach ($type as $itemKey => $item)
                                            @if ($category->type == $itemKey)
                                                {{ $key . ': ' . $item }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    {{ $category->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary" wire:click="edit({{ $category->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" wire:click="delete({{ $category->id }})">
                                        <i class="fa fa-trash"></i>
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
                {!! $categories->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

    <!-- Modal -->
    <div class="modal fade" id="form-category" tabindex="-1" role="dialog" aria-labelledby="form-categoryLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-categoryLabel">
                        @if($method)
                        Editar Categoria
                        @else
                        Nova Categoria
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
                            {{ Form::label('categoryInput', 'Nome da categoria:') }}

                            {{ Form::text('categoryInput', null, ['class' => 'form-control', 'placeholder' => 'Pregão Eletrônico', 'wire:model' => 'categoryInput']) }}
                            @error('categoryInput')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('statusInput', 'Status: ') }}

                            {{                             Form::select('statusInput', ['1' => 'Ativado', '0' => 'Desativado'], null, ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'statusInput']) }}
                            @error('statusInput')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('type', 'Tipo: ') }}
                            {{ Form::select('typeInput', $types, null, ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'typeInput']) }}
                            @error('typeInput')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('special_fieldInput', 'Campo especial: ') }}

                            {{ Form::select('special_field', ['0' => 'Desabilitado', '1' => 'Habilitado'], null, ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'special_fieldInput']) }}
                            @error('special_fieldInput')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('in_graficInput', 'Considerar em gráficos: ') }}

                            {{ Form::select('in_graficInput', ['0' => 'Não', '1' => 'sim'], null, ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'in_graficInput']) }}
                            @error('in_graficInput')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('colorInput', 'Cor:') }}

                            {{ Form::color('colorInput', null, ['class' => 'form-control', 'wire:model' => 'colorInput']) }}

                            @error('colorInput')
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
        $('#form-category').modal('show');

    });
    window.addEventListener('close-form', event => {
        $('#form-category').modal('hide');
    });
    window.addEventListener('delete-category', event => {

        Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed){
                Livewire.emit('destroyCategory');
            }
        });
    });
</script>
@stop
