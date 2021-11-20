<div class="tab-pane" id="additional" wire:ignore.self>

    @if ($methodForm == 'create')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
            data-target="#form-additional">
                Adicionar
        </button>
    @endif

    <div class="my-4">
        @if ($biddingAdditional)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Nº Edital
                        </th>
                        <th>
                            Inicio do acolhimento das Propostas
                        </th>
                        <th>
                            Limite do acolhimento das Propostas
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $biddingAdditional->notice_number }}
                        </td>
                        <td>
                            {{ isset($biddingAdditional->bid_opening_date) ? date('d/m/Y', strtotime($biddingAdditional->bid_opening_date)) : '-' }}
                    {{ isset($biddingAdditional->bid_opening_hour) ? date('H:i', strtotime($biddingAdditional->bid_opening_hour)) : '' }}
                        </td>
                        <td>
                            {{ isset($biddingAdditional->bid_closing_date) ? date('d/m/Y', strtotime($biddingAdditional->bid_closing_date)) : '-' }}
                            {{ isset($biddingAdditional->bid_closing_hour) ? date('H:i', strtotime($biddingAdditional->bid_closing_hour)) : '' }}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" wire:click="deleteAdditional">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                                data-target="#form-additional">
                                    <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            Descrição:
            {!! $biddingAdditional->description !!}
        </div>

        @endif
    </div>
    <div class="modal fade" id="form-additional" tabindex="-1" role="dialog" aria-labelledby="additionalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="additionalLabel">Informações do certame</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($methodForm == 'update')
                    {{ Form::open(['wire:submit.prevent' => 'update']) }}
                @else
                    {{ Form::open(['wire:submit.prevent' => 'create']) }}
                @endif

                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('notice_number', 'Edital:') }}
                        {{ Form::text('notice_number', null, ['class' => 'form-control', 'wire:model' => 'notice_number']) }}
                        @error('notice_number')
                            <p class="text-danger"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col">
                            {{ Form::label('bid_opening_date', 'Data de inicio das propostas:') }}
                            {{ Form::date('bid_opening_date', null, ['class' => 'form-control', 'wire:model' => 'bid_opening_date']) }}
                            @error('bid_opening_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            {{ Form::label('bid_opening_hour', 'Hora de inicio das propostas:') }}
                            {{ Form::time('bid_opening_hour', null, ['class' => 'form-control', 'wire:model' => 'bid_opening_hour']) }}
                            @error('bid_opening_hour')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{ Form::label('bid_closing_date', 'Data final das propostas:') }}
                            {{ Form::date('bid_closing_date', null, ['class' => 'form-control', 'wire:model' => 'bid_closing_date']) }}
                            @error('bid_closing_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            {{ Form::label('bid_closing_hour', 'Hora final das propostas:') }}
                            {{ Form::time('bid_closing_hour', null, ['class' => 'form-control', 'wire:model' => 'bid_closing_hour']) }}
                            @error('bid_closing_hour')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">

                        {{ Form::label('description', 'Descrição:') }}
                        {{Form::textarea('description', null, ['class' => 'form-control',
                         'placeholder' => 'Ex. Aquisição de...', 'rows' => '4', 'wire:model' => 'description']) }}

                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::button('Cancelar', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) }}
                    {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

</div>
@push('js')
    <script>
        window.addEventListener('close-form-additonal', event => {
            $('#form-additional').modal('hide');
        });
    </script>
    <script>
         window.addEventListener('delete-additonal', event => {

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
                        Livewire.emit('destroyAdditional');
                    }
                });
            });

    </script>
@endpush
