<div class="tab-pane" id="documents" wire:ignore.self>
{{ Form::open(['wire:submit.prevent' => 'save']) }}
    <div class="card">
    <div class="card-body">
        <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            {{ Form::label('Documento:', 'Documento:') }}

            {{ Form::text('name', null, ['class' => 'form-control', 'required', 'list' => 'document_list', 'autocomplete' => 'off', 'wire:model'=>'name']) }}
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <datalist id="document_list">
                @foreach ($documentsList as $documentList)
                  <option value="{{ $documentList }}">
                @endforeach
              </datalist>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group">
                {{ Form::label('description', 'Descrição:') }}

                {{ Form::text('description', null, ['class' => 'form-control', 'autocomplete' => 'off','wire:model'=>'description']) }}
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        </div>
        <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
            <div class="custom-file">
                <input type="file" class="w-full" wire:model="document" id="document">

                @error('document')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            </div>

        </div>
        <div class="col">
            <div class="form-group">
            {{ Form::submit('Incluir', ['class' => 'btn btn-success']) }}
            </div>
        </div>
        </div>
        <div wire:loading wire:target="document" class="spinner-border text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>

    </div>
    </div>

    {{ Form::close() }}
    <div wire:loading wire:target='render'>...</div>
    <div class="table-responsive" >
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Documento</th>
            <th>Descrição</th>
            <th>Ação</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($biddingDocuments as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>@isset($item->description)
                    {{ $item->description }}
                @else
                    -
                @endisset</td>
                <td style="width: 20%">
                <div class="row">
                    <div class="col">
                    <button class="btn btn-danger" wire:click="delete({{$item->id}})">
                        <i class="fa fa-trash"></i>
                    </button>


                    </div>
                    <div class="col">
                    <a href="{{ $item->getRealPath() }}" target="_black" class="btn btn-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                    </div>
                </div>
                </td>

            </tr>
            @empty
            <td colspan="3">
                <p class="text-muted">Não há documentos para o Processo: {{ $bidding->getRealNumber() }}</p>
            </td>

            @endforelse

        </tbody>
        </table>
    </div>

</div>
<!-- /.tab-pane -->

@push('js')
    <script>
        window.addEventListener('clearInput', event => {
            document.getElementById("document").value = "";
        });
        window.addEventListener('delete-document', event => {

            Swal.fire({
            title: 'Tem certeza?',
            text: "o arquivo: '" +event.detail.name + "' será removido. Você não poderá reverter isso!",
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
