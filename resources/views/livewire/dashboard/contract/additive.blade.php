<div class="tab-pane" id="additive" wire:ignore.self>
    <div class="my-2 float-right">
        <button type="button" class="btn btn-primary" wire:click="create">
            Adicionar Aditivos
        </button>
    </div>
    @if ($contactAdditives)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        </th>
                        <th>Sequência</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor modificado</th>
                        <th>Valor Total</th>
                        <th>Ação</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($contactAdditives as $additive)
                        <tr>

                            <td>{{ $additive->sequence }}</td>
                            <td class="text-justify text-break">{{ $additive->description }}</td>
                            <td style="width: 20%">
                                @if ($additive->type_modification == 3)
                                    Recisção Contatual
                                @elseif($additive->type_modification == 0)
                                    INICIAL
                                @else

                                    Aditivo Contratual
                                @endif
                            </td>
                            <td style="width: 10%" class="text-break">

                                @if ($additive->type_modification == 0)
                                -
                                @elseif ($additive->type_modification == 1)
                                    Acréscimo: {{ number_format($additive->addition_value, 2, ',', '.') }}
                                @elseif($additive->type_modification == 2)
                                    Decréscimo: {{ number_format($additive->decrease_value, 2, ',', '.') }}
                                @else
                                    Recisção: {{ number_format($additive->termination_value, 2, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                {{ number_format($additive->total_value, 2, ',', '.') }}
                            </td>
                            </td>
                            <td class="text-center " style="width: 10%">
                                <div class="d-flex">
                                    @if($additive->type_modification != 0)
                                        <button type="button" class="btn btn-danger"
                                        wire:click="delete({{ $additive->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif

                                    <button type="button" wire:click="edit({{ $additive->id }})"
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
    <div class="modal fade" id="form-additive" tabindex="-1" role="dialog"
        aria-labelledby="form-additive-label" aria-hidden="true" data-backdrop="static" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($method)
                        <h5 class="modal-title" id="form-additive-label">Editar Aditivo</h5>
                    @else
                        <h5 class="modal-title" id="form-additive-label">Criar Aditivo</h5>
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
                    @if ($type_modification !=0)


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('sequence', 'Sequência:') }}
                                {{ Form::number('sequence', $sequence, ['class' => 'form-control', 'disabled']) }}

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('type_modification', 'Tipo de modificação:') }}
                                {{ Form::select('type_modification', ['1' => 'Acréscimo',
                                '2' => 'Decréscimo', '3' =>'Recisão'],null,['class' => 'form-control', 'placeholder' => 'Selecione' ,
                                'wire:model' =>
                                'type_modification']) }}

                                @error('type_modification')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                @if ($type_modification == 1)
                                    {{ Form::label('addition_value', 'Valor do acréscimo:') }}
                                    {{ Form::number('addition_value', null, ['class' => 'form-control', 'wire:model' => 'addition_value', 'step'=> '0.010']) }}
                                    @error('addition_value')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                @elseif($type_modification == 2 )
                                    {{ Form::label('decrease_value', 'Valor descrécimo:') }}
                                    {{ Form::number('decrease_value', null, ['class' => 'form-control', 'wire:model' => 'decrease_value',  'step'=> '0.010']) }}
                                    @error('decrease_value')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                @elseif($type_modification == 3)
                                    {{ Form::label('termination_value', 'Valor da recisão:') }}
                                    {{ Form::number('termination_value', null, ['class' => 'form-control', 'wire:model' => 'termination_value', 'step'=> '0.010']) }}
                                    @error('termination_value')
                                        <p class="text-danger"> {{ $message }} </p>
                                    @enderror
                                @else
                                    <div class="d-flex flex-wrap align-content-center">
                                        <p class="text-muted text-center p-2">Selecione o tipo de modificação</p>
                                    </div>

                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('total_value', 'Valor total:') }}
                                {{ Form::number('total_value', null, ['class' => 'form-control', 'wire:model' => 'total_value']) }}
                                @error('total_value')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @else

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {{ Form::label('sequence', 'Sequência:') }}
                                {{ Form::number('sequence', $sequence, ['class' => 'form-control', 'disabled']) }}

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{ Form::label('total_value', 'Valor total:') }}
                                {{ Form::number('total_value', null, ['class' => 'form-control', 'wire:model' => 'total_value']) }}
                                @error('total_value')
                                    <p class="text-danger"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @endif
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('signature_date', 'Data da Assinatura:')}}
                                {{Form::date('signature_date', null, ['class'=>'form-control', 'wire:model' => 'signature_date'])}}
                                @error('signature_date')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('start_validity', 'Inicio da Vigência:')}}
                                {{Form::date('start_validity', null, ['class'=>'form-control', 'wire:model' => 'start_validity'])}}
                                @error('start_validity')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {{Form::label('end_term', 'Fim da Vigência :')}}
                                {{Form::date('end_term', null, ['class'=>'form-control', 'wire:model' => 'end_term'])}}
                                @error('end_term')
                                    <p class="text-danger">{{ $message }}</p>
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
        window.addEventListener('open-form-additive', event => {
            $('#form-additive').modal('show');
        });
        window.addEventListener('close-form-additive', event => {
            $('#form-additive').modal('hide');
        });

    </script>
    <script>
        window.addEventListener('open-form-additive-delete', event => {

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
                    Livewire.emit('destroyadditive');
                }
            });
        });
    </script>
@endpush
