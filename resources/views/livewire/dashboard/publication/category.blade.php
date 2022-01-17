<div class="tab-pane" id="category" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    </th>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Status</th>

                    <th>Ação</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>

                        <td>{{ $category->id }}</td>
                        <td>{{ $category->type }}</td>
                        <td>{{ $category->status ? 'Habilitado' : 'Desabilitado' }}</td>

                        <td class="text-center " style="width: 10%">
                            <div class="d-flex">

                                <button type="button" wire:click="edit({{ $category->id }})"
                                    class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Não há Titulo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $categories->links() !!}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form-category" tabindex="-1" role="dialog" aria-labelledby="form-categoryLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-categoryLabel">
                        @if($method)
                        Editar Titulo
                        @else
                        Nova Titulo
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
                            {{ Form::label('type', 'Titulo:') }}

                            {{ Form::text('type', null, ['class' => 'form-control', 'placeholder' => 'Titulo', 'wire:model' => 'type']) }}
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
@push('js')
<script>
    window.addEventListener('open-form-category', event => {
        $('#form-category').modal('show');

    });
    window.addEventListener('close-form-category', event => {
        $('#form-category').modal('hide');
    });

</script>

@endpush
