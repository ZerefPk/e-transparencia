<div class="tab-pane" id="efforts" wire:ignore.self>
    {{ Form::open(['wire:submit.prevent' => 'store']) }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        {{ Form::label('Numero do empenho:', 'Numero do empenho:') }}

                        {{ Form::text('number_effort', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'wire:model' => 'number_effort']) }}
                        @error('number_effort')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <div wire:ignore>
                            <label for="effort-select">Histórico do Empenho: </label>
                            <select class="form-control" id="effort-select" style="width: 100%">
                                <option selected disabled>Selecione</option>
                                @foreach ($efforts as $effort)
                                    <option value="{{ $effort->id }}">{{$effort->getRealNumber()}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('effort_id')
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
    <div wire:loading wire:target='render' class="spinner-border text-success" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numero do empenho</th>
                    <th>Ação</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($contractEfforts as $contractEffort)
                    <tr>
                        <td>{{$contractEffort->number_effort}}</td>

                        <td style="width: 20%">
                            <div class="row">

                                <div class="col">
                                    <button class="btn btn-danger" wire:click="delete({{ $contractEffort->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>


                                </div>
                                <div class="col">
                                    <a href="{{ $contractEffort->getRealPath() }}" target="_black" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                @empty
                    <td colspan="3">
                        <p class="text-muted">Não há empenho para o contrato: {{ $contract->getRealNumber() }}
                        </p>
                    </td>

                @endforelse

            </tbody>
        </table>
    </div>

</div>
<!-- /.tab-pane -->
@section('css')
<link rel="stylesheet" href="{{url('css/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@endsection
@push('js')
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script>
        $('#effort-select').select2({
            theme: 'bootstrap4',
        })
        $('#effort-select').on('change', function(e) {
                var data = $('#effort-select').select2("val");
                @this.set('effort_id', data);
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
