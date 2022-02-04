@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Ato Normativo: Novo</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"> <a href="{{ route('dashboard.contract.index') }}">Ato Normativos</a></li>
                <li class="breadcrumb-item active">Novo</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    {!! Form::open(['wire:submit.prevent' => 'store']) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Novo Ato Normativo</h3>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col">
                    <div class="form-group">
                        {{ Form::label('year', 'Ano: ') }}

                        {{ Form::select('year', $years, null, ['placeholder' => 'Selecione um ano','class' => 'form-control','wire:model' => 'year']) }}
                        @error('year')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('number', 'Numero:') }}

                        {{ Form::text('number', null, ['class' => 'form-control','placeholder' => 'Ex. 000001','wire:model' => 'number']) }}
                        @error('number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {{ Form::label('type_id', 'Tipo: ') }}

                        {{ Form::select('type_id', $types, null, ['placeholder' => 'Selecione um tipo','class' => 'form-control','wire:model' => 'type_id']) }}
                        @error('type_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">

                {{ Form::label('ementa', 'Ementa:') }}

                {{ Form::textarea('ementa', null, ['class' => 'form-control','id' => 'ementa','placeholder' => 'Ementa','rows' => '4','wire:model' => 'ementa']) }}

                @error('ementa')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">

                {{ Form::label('description', 'Descrição:') }}

                {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'description','placeholder' => 'Descrição','rows' => '4','wire:model' => 'description']) }}

                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="custom-file">
                            {{ Form::label('doc', 'DOCX, DOC:') }}
                            <input type="file" class="form-control" wire:model="doc" id="doc">

                            @error('doc')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="custom-file">
                            {{ Form::label('pdf', 'PDF:') }}
                            <input type="file" class="form-control" wire:model="pdf" id="pdf">

                            @error('pdf')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            @if ($journaling)
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            {{ Form::label('active', 'Em vigor:') }}

                            {{ Form::select('active', ['1' => 'Sim', '0' => 'Não'], null, ['class' => 'form-control','placeholder' => 'Selecione','wire:model' => 'active']) }}
                            @error('active')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            {{ Form::label('publication_date', 'Data da Publicação:') }}

                            {{ Form::date('publication_date', null, ['class' => 'form-control', 'wire:model' => 'publication_date']) }}
                            @error('publication_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            {{ Form::label('date_journal_publication', 'Data da Publicação em Diário:') }}

                            {{ Form::date('date_journal_publication', null, ['class' => 'form-control','wire:model' => 'date_journal_publication']) }}
                            @error('date_journal_publication')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">

                            {{ Form::label('status', 'Status:') }}

                            {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desabilitado'], null, ['class' => 'form-control','placeholder' => 'Selecione','wire:model' => 'status']) }}
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            @else
                <div class="row">

                    <div class="col">
                        <div class="form-group">
                            {{ Form::label('active', 'Em vigor:') }}

                            {{ Form::select('active', ['1' => 'Sim', '0' => 'Não'], null, ['class' => 'form-control','placeholder' => 'Selecione','wire:model' => 'active']) }}
                            @error('active')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ Form::label('publication_date', 'Data da Publicação:') }}

                            {{ Form::date('publication_date', null, ['class' => 'form-control', 'wire:model' => 'publication_date']) }}
                            @error('publication_date')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">

                            {{ Form::label('status', 'Status:') }}

                            {{ Form::select('status', ['1' => 'Habilitado', '0' => 'Desabilitado'], null, ['class' => 'form-control','placeholder' => 'Selecione','wire:model' => 'status']) }}
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>



        <div class="card-footer">
            <a class="btn  btn-secondary" href="{{ route('dashboard.nomativesacts.index') }}">Cancelar</a>
            {{ Form::submit('Salvar', ['class' => 'btn  btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
</div>
@section('css')

@stop
@push('js')


@endpush
