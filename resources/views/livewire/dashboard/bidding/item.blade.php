<div class="tab-pane" id="item" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar Item
        </button>
    </div>
    @if ($biddingItens)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        </th>
                        <th>Item</th>
                        <th>Descrição</th>
                        <th>Unidade</th>
                        <th>Quantidade</th>
                        <th>Valor Total</th>
                        <th>Ação</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($biddingItens as $item)
                        <tr>

                            <td>{{ $item->item }}</td>
                            <td>{!! $item->description !!}</td>
                            <td style="width: 20%">{{ $item->unity }}</td>
                            <td style="width: 10%" class="text-break">{{ $item->quantity }}</td>

                            <td>R$ {{ number_format($item->estimated_total_value, 2, ',', '.') }}</td>
                            <td class="text-center " style="width: 10%">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-danger"
                                        wire:click="delete({{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button type="button" wire:click="edit({{ $item->id }})"
                                        class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                Não há itens para o Processo:
                                {{ $bidding->getRealNumber() }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    @endif
    <div class="modal fade" id="form-item-create" tabindex="-1" role="dialog"
        aria-labelledby="form-item-create-label" aria-hidden="true" data-backdrop="static" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-item-create-label">Criar item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>

                    </button>
                </div>
                {{ Form::open(['wire:submit.prevent' => 'store']) }}
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('item', 'Item:') }}
                                {{ Form::number('item', $sequence, ['class' => 'form-control', 'disabled']) }}

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('unity', 'Unidade:') }}
                                {{ Form::text('unity', null, ['class' => 'form-control', 'list' => 'unityList1', 'wire:model' => 'unity']) }}
                                <datalist id="unityList1">

                                    @foreach ($unityList as $list)
                                        <option value="{{ $list }}">
                                    @endforeach

                                </datalist>
                                @error('unity')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('quantity', 'Quantidade:') }}
                                {{ Form::number('quantity', null, ['class' => 'form-control', 'wire:model' => 'quantity']) }}
                                @error('quantity')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('catmat', 'Catmat:') }}
                                {{ Form::number('catmat', null, ['class' => 'form-control', 'wire:model' => 'catmat']) }}
                                @error('catmat')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('estimated_total_value', 'Valor total estimado:') }}
                                {{ Form::number('estimated_total_value', null, ['class' => 'form-control', 'wire:model' => 'estimated_total_value']) }}
                                @error('value_total_estimed')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Descrição:') }}
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'wire:model' => 'description']) }}
                        @error('description')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::button('Fechar', ['class' => 'btn btn-warning', 'data-dismiss' => 'modal']) }}
                    {{ Form::submit('Salva', ['class' => 'btn btn-success']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div>
        <div class="modal fade" id="form-item-edit" tabindex="-1" role="dialog"
            aria-labelledby="form-item-edit-label" aria-hidden="true" data-backdrop="static" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-item-edit-label">Editar item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>
                    </div>
                    {{ Form::open(['wire:submit.prevent' => 'update']) }}
                    <div class="modal-body">

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ Form::label('item', 'Item:') }}
                                    {{ Form::number('item', $sequence, ['class' => 'form-control', 'disabled']) }}

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('unity', 'Unidade:') }}
                                    {{ Form::text('unity', null, ['class' => 'form-control', 'list' => 'unityList', 'wire:model' => 'unity']) }}
                                    <datalist id="unityList">
                                        @foreach ($unityList as $list)
                                            <option value="{{ $list }}">
                                        @endforeach
                                    </datalist>
                                    @error('unity')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    {{ Form::label('quantity', 'Quantidade:') }}
                                    {{ Form::number('quantity', null, ['class' => 'form-control', 'wire:model' => 'quantity']) }}
                                    @error('quantity')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ Form::label('catmat', 'Catmat:') }}
                                    {{ Form::number('catmat', null, ['class' => 'form-control', 'wire:model' => 'catmat']) }}
                                    @error('catmat')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    {{ Form::label('estimated_total_value', 'Valor total estimado:') }}
                                    {{ Form::number('estimated_total_value', null, ['class' => 'form-control', 'wire:model' => 'estimated_total_value']) }}
                                    @error('value_total_estimed')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', 'Descrição:') }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'wire:model' => 'description']) }}
                            @error('description')
                                <p class="text-danger"> {{ $message }} </p>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Fechar', ['class' => 'btn btn-warning', 'data-dismiss' => 'modal']) }}
                        {{ Form::submit('Salva', ['class' => 'btn btn-success']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div>


        </div>
    </div>
</div>
@push('js')
    <script>
        window.addEventListener('open-form-item-create', event => {
            $('#form-item-create').modal('show');
        });
        window.addEventListener('close-form-item-create', event => {
            $('#form-item-create').modal('hide');
        });
        window.addEventListener('open-form-item-edit', event => {
            $('#form-item-edit').modal('show');
        });
        window.addEventListener('close-form-item-edit', event => {
            $('#form-item-edit').modal('hide');
        });
    </script>
    <script>
        window.addEventListener('open-form-item-delete', event => {

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
                if (result.isConfirmed) {
                    Livewire.emit('destroyItem');
                }
            });
        });
    </script>
@endpush
