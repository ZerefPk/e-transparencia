<div class="tab-pane" id="wins" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar vencendor
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    </th>

                    <th>Item</th>
                    <th>Fornecedor</th>
                    <th>Valor da Proposta</th>
                    <th>Ação</th>


                </tr>
            </thead>
            <tbody>

                @forelse ($wins  as  $win)
                <tr>


                    <td>{{ $win->id}}

                    </td>

                    <td>
                        {{ $win->provider->type ? $win->provider->cnpj : $win->provider->cpf }} -
                        {{ $win->provider->corporate_name }}
                    </td>


                    <td>R$ {{ number_format($win->approved_value, 2, ',', '.') }}</td>
                    <td class="text-center " style="width: 10%">
                        <div class="d-flex">
                            <button type="button" class="btn btn-danger"
                                wire:click="delete({{ $win->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </td>

                </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Não há vencedores para o Processo:
                            {{ $bidding->getRealNumber() }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="form-win" tabindex="-1" role="dialog" aria-labelledby="form-win-label"
        aria-hidden="true" data-backdrop="static" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-win-label">Adicionar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>

                    </button>
                </div>
                {{ Form::open(['wire:submit.prevent' => 'store']) }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="-select" for="bidding_item_id">Item: </label>
                        <select class="form-control" name="bidding_item_id" wire:model="bidding_item_id">
                            <option selected >Selecione</option>
                            @foreach ($itens as $item)
                                @if (!$item->win)
                                    <option value="{{ $item->id }}"> ITEM: {{ $item->item }} - R$
                                    {{ number_format($item->estimated_total_value, 2, ',', '.') }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('bidding_item_id')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="provider-select">Fornecedor: </label>
                            <select class="form-control" id="provider-select" style="width: 100%" x-init="
                            $('#provider-select').select2({
                                theme: 'bootstrap4',
                                dropdownParent:  $('#form-win'),

                            });">
                                <option selected >Selecione</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">
                                        {{ $provider->type ? $provider->cnpj : $provider->cpf }} -
                                        {{ $provider->corporate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('provider_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('approved_value', 'Valor total estimado:') }}
                        {{ Form::number('approved_value', null, ['class' => 'form-control', 'wire:model' => 'approved_value']) }}
                        @error('value_total_estimed')
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

@section('css')
<link rel="stylesheet" href="{{url('css/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@endsection

@push('js')
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            $('#provider-select').select2({
                theme: 'bootstrap4',
                dropdownParent:  $('#form-win'),

            });

            $('#provider-select').on('change', function(e) {
                    var data = $('#provider-select').select2("val");
                    @this.set('provider_id', data);
                });
        });
    </script>
    <script>
        window.addEventListener('open-form-win', event => {
            $('#form-win').modal('show');
        });
        window.addEventListener('close-form-win', event => {
            $('#form-win').modal('hide');
        });
    </script>
    <script>
        window.addEventListener('open-form-win-delete', event => {

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
                    Livewire.emit('destroyWin');
                }
            });
        });
    </script>
@endpush
