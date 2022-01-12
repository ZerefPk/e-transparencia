<div >
    <!-- Modal -->
    <div class="modal fade" id="create-category" tabindex="-1" role="dialog" aria-labelledby="create-categoryLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document" >
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="create-categoryLabel">Nova Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['wire:submit.prevent'=>'create']) !!}
                <div class="modal-body" >


                    <div class="row">
                        <div class="col-sm-8">
                            {{ Form::label('category', 'Nome da categoria:') }}

                            {{ Form::text('category', null, ['class' => 'form-control',
                            'placeholder' => 'Pregão Eletrônico', 'wire:model' => 'category']) }}
                            @error('category')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('status', 'Status: ') }}

                            {{ Form::select('status', ['1' => 'Ativado', '0' => 'Desativado'], null,
                             ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'status']) }}
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('type', 'Tipo: ') }}
                            {{ Form::select('type', $types, null, ['placeholder' => 'selecione',
                            'class' => 'form-control', 'wire:model' => 'type']) }}
                            @error('type')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('special_field', 'Campo especial: ') }}

                            {{ Form::select('special_field', ['0' => 'Desabilitado', '1' => 'Habilitado'], null,
                            ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'special_field']) }}
                            @error('special_field')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('in_grafic', 'Considerar em gráficos: ') }}

                            {{ Form::select('in_grafic', ['0' => 'Não', '1' => 'sim'], null,
                            ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model' => 'in_grafic']) }}
                            @error('in_grafic')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('color', 'Cor:') }}

                            {{ Form::color('color', null, ['class' => 'form-control', 'wire:model' => 'color']) }}

                            @error('color')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit("Salvar", ['class'=>'btn btn-success']) !!}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
