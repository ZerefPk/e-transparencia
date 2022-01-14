<div class="tab-pane active" id="documents" wire:ignore.self>
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
                    <th>Titulos</th>
                    <th>Ano</th>
                    <th>Publicação</th>
                    <th>Descrição</th>

                    <th>Ação</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($documentsReport as $document)
                    <tr>

                        <td>{{ $document->id }}</td>
                        <td>{{ $document->type->type }}</td>
                        <td>{{ $document->year }}</td>
                        <td>{{ $document->publication_date }}</td>
                        <td class="text-justify">{{ (isset($document->description)>0) ? $document->description : '-' }}</td>


                        <td class="text-center " style="width: 10%">
                            <div class="d-flex">

                                <button type="button" wire:click="delete({{ $document->id }})"
                                    class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Não há relatórios
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $documentsReport->links() !!}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form-report" tabindex="-1" role="dialog" aria-labelledby="form-reportLabel"
        aria-hidden="true" data-backdrop="static"  wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="form-reportLabel">
                        Novo relatório
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {!! Form::open(['wire:submit.prevent' => 'store']) !!}

                <div class="modal-body">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('year', 'Ano:') }}

                                {{ Form::select('year', $years, null,['placeholder' => 'selecione','class' => 'form-control', 'wire:model' => 'year']) }}
                                @error('year')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('publication_date', 'Publicação:') }}

                            {{ Form::date('publication_date', null, ['class' => 'form-control', 'placeholder' => 'Categoria', 'wire:model' => 'publication_date']) }}
                            @error('publication_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('type_id', 'Titulo: ') }}

                            {{ Form::select('type_id', $types, null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'type_id']) }}
                            @error('type_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('document', 'Relatório [PDF]: ') }}

                            {{ Form::file('document',['class' => 'form-control', 'wire:model' => 'document']) }}
                            @error('document')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div wire:loading wire:target="document" class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            {{ Form::label('description', 'Descrição: ') }}

                            {{ Form::textarea('description',null,['class' => 'form-control','wire:model' => 'description' ,'row' => '5']) }}
                            @error('description')
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
    window.addEventListener('open-form-report', event => {
        $('#form-report').modal('show');

    });
    window.addEventListener('close-form-report', event => {
        $('#form-report').modal('hide');
        document.getElementById("document").value = "";
    });

</script>
<script>
    window.addEventListener('delete-document', event => {
        Swal.fire({
        title: 'Tem certeza?',
        text: "o relatório será removido. Você não poderá reverter isso!",
        icon: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed){
                Livewire.emit('destroy');
            }
        });
    });

</script>

@endpush
