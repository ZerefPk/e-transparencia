<div class="tab-pane" id="item" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar Item
        </button>
    </div>
    @if ($contractItens)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        </th>
                        <th>Item</th>
                        <th>Descrição</th>
                        <th>Unidade</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Ação</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($contractItens as $item)
                        <tr>

                            <td>{{ $item->item }}</td>
                            <td>{!! $item->description !!}</td>
                            <td style="width: 20%">{{ $item->unity }}</td>
                            <td style="width: 10%" class="text-break">{{ $item->quantity }}</td>

                            <td>Unitário: R$ {{ number_format($item->unity_value, 2, ',', '.') }} <br>
                                Total: R$ {{ number_format($item->total_value, 2, ',', '.') }}
                            </td>
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
                                Não há itens para o contrato:
                                {{ $contract->getRealNumber() }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    @endif
    <div class="modal fade" id="form-item" tabindex="-1" role="dialog"
        aria-labelledby="form-item-label" aria-hidden="true" data-backdrop="static" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($method)
                        <h5 class="modal-title" id="form-item-label">Editar item</h5>
                    @else
                        <h5 class="modal-title" id="form-item-label">Criar item</h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>

                    </button>
                </div>
                @if ($method)
                {{ Form::open(['wire:submit.prevent' => 'update']) }}
                @else
                {{ Form::open(['wire:submit.prevent' => 'store']) }}
                @endif

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
                                {{ Form::label('unity_value', 'Valor unitário:') }}
                                {{ Form::number('unity_value', null, ['class' => 'form-control', 'wire:model' => 'unity_value', 'step'=> '0.01']) }}
                                @error('unity_value')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('total_value', 'Valor total:') }}
                                {{ Form::number('total_value', null, ['class' => 'form-control', 'wire:model' => 'total_value', 'step'=> '0.01' ]) }}
                                @error('total_value')
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

</div>
@push('js')
    <script>
        window.addEventListener('open-form-item', event => {
            $('#form-item').modal('show');
        });
        window.addEventListener('close-form-item', event => {
            $('#form-item').modal('hide');
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
