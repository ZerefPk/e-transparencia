<div class="tab-pane" id="efforts" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar empenho
        </button>
    </div>
    <div wire:loading wire:target='render' class="spinner-border text-success" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numero do empenho</th>
                    <th>data do empenho</th>
                    <th>Valor do empenho</th>
                    <th>tipo de empenho</th>
                    <th>Ação</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($contractEfforts as $contractEffort)
                    <tr>
                        <td>{{ $contractEffort->number_effort }}</td>
                        <td>{{ date('d/m/Y', strtotime($contractEffort->date_effort))  }}</td>
                        <td>{{ number_format($contractEffort->total_value, 2, ',', '.') }}</td>
                        <td>{{ $typesEfforts[$contractEffort->type_effort] }}</td>


                        <td style="width: 20%">
                            <div class="row">


                                <div class="col">
                                    <a href="{{ $contractEffort->getRealPath() }}" target="_black"
                                        class="btn btn-primary">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <button class="btn btn-danger" wire:click="delete({{ $contractEffort->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>

                    </tr>
                @empty
                    <td colspan="5">
                        <p class="text-muted">Não há empenho para o contrato: {{ $contract->getRealNumber() }}
                        </p>
                    </td>

                @endforelse

            </tbody>
        </table>
    </div>
    <div class="modal fade" id="form-effort" tabindex="-1" role="dialog" aria-labelledby="form-effort-label"
        aria-hidden="true" data-backdrop="static" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-effort-label">Adicionar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>

                    </button>
                </div>
                {{ Form::open(['wire:submit.prevent' => 'store']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div wire:ignore>
                                <label for="effort-select">Histórico do Empenho: </label>
                                <select class="form-control" id="effort-select" style="width: 100%" x-init="$('#effort-select').select2({
                                    theme: 'bootstrap4',
                                    dropdownParent: $('#form-effort'),

                                });">
                                    <option selected>Selecione</option>
                                    @foreach ($efforts as $effort)
                                        <option value="{{ $effort->id }}">{{$effort->getRealNumber()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>Buscar</label>
                            <button type="button" class="btn btn-primary text-center" wire:click="setEffort">
                                <i class="fa fas fa-search"></i>
                            </button>

                        </div>

                        @error('effort_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('number_effort', 'Numero do empenho:') }}

                                {{ Form::text('number_effort', null, ['class' => 'form-control', 'autocomplete' => 'off', 'wire:model' => 'number_effort']) }}
                                @error('number_effort')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('type_effort', 'Tipo de empenho:') }}

                                {{ Form::select('type_effort', $typesEfforts, null, ['class' => 'form-control', 'placeholder' => 'Selecione', 'wire:model' => 'type_effort']) }}
                                @error('type_effort')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('total_value', 'Valor do empenho R$:') }}

                                {{ Form::number('total_value', null, ['class' => 'form-control',
                                'autocomplete' => 'off', 'step' => '.01','wire:model' => 'total_value']) }}
                                @error('total_value')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                {{ Form::label('date_effort', 'Valor do empenho R$:') }}

                                {{ Form::date('date_effort', null, ['class' => 'form-control',
                                'autocomplete' => 'off','wire:model' => 'date_effort']) }}
                                @error('date_effort')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <div class="custom-file">
                                    <label for="document">Documento</label>
                                    <input type="file" class="w-full" wire:model="document" id="document">

                                    @error('document')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div wire:loading wire:target="document" class="spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::button('Fechar', ['class' => 'btn btn-warning',
                    'data-dismiss' => 'modal', 'wire:click' => 'resetAttributes']) }}
                    {{ Form::submit('Salva', ['class' => 'btn btn-success']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<!-- /.tab-pane -->
@section('css')
    <link rel="stylesheet" href="{{ url('css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@endsection
@push('js')
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            $('#effort-select').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#form-effort'),

            });

            $('#effort-select').on('change', function(e) {
                var data = $('#effort-select').select2("val");
                @this.set('effort_id', data);
            });
        });
    </script>
    <script>
        window.addEventListener('open-form-effort', event => {
            $('#form-effort').modal('show');
        });
        window.addEventListener('close-form-effort', event => {
            $('#form-effort').modal('hide');
        });
    </script>

    <script>
        window.addEventListener('clearInput', event => {
            document.getElementById("document").value = "";
        });
        window.addEventListener('delete-effort', event => {

            Swal.fire({
                title: 'Tem certeza?',
                text: "o Empenho: '" + event.detail.number_effort +
                    "' será removido. Você não poderá reverter isso!",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, delete',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('destroyEffort');
                }
            });
        });
    </script>
@endpush
