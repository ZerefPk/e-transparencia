@section('title', 'Dashboard')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Licitação: Nova</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"> <a href="{{route('dashboard.bidding.index')}}">Licitação</a></li>
      <li class="breadcrumb-item active">edit</li>
    </ol>
  </div><!-- /.col -->
</div><!-- /.row -->
@stop


{{ Form::open(['wire:submit.prevent'=>'submit']) }}
<div class="row">
  <div class="col-md-8">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Informações Gerais</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col">
                <div class="form-group">
                  {{ Form::label('year', 'Ano: ') }}

                  {{ Form::select('year', $years, null, ['placeholder' =>
                  'Selecione um ano', 'class' => 'form-control', 'wire:model'=>"year"]) }}
                  @error('year')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  {{ Form::label('number', 'Numero do Processo:') }}

                  {{ Form::text('number', null, ['class' => 'form-control', 'placeholder' => 'Ex. 000001','wire:model'=>'number']) }}
                  @error('number')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

            </div>
            <div class="form-group">

              {{ Form::label('object', 'Objeto:') }}

            {{ Form::textarea('object', null, ['class' => 'form-control', 'id' => 'object',
                'placeholder' => 'Ex. Aquisição de...', 'rows' => '4','wire:model'=>'object']) }}

              @error('object')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="row">

              <div class="col">
                <div class="form-group">
                  {{ Form::label('estimated_value', 'Valor estimando R$:') }}

                  {{ Form::number('estimated_value', null, ['class' => 'form-control', 'step' => '.01',
                  'placeholder' => 'Ex. 300,00', 'wire:model'=>'estimated_value']) }}
                  @error('estimated_value')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  {{ Form::label('contracted_value', 'Valor contratado R$:') }}

                  {{ Form::number('contracted_value', null, ['class' => 'form-control', 'step' => '.01',
                  'placeholder' => 'Ex. 300,00', 'wire:model'=>'contracted_value']) }}
                  @error('estimated_value')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

            </div>
            <div class="form-group">

              {{ Form::label('budget_information', 'Informação orçamentaria:') }}
            <div wire:ignore>
                {{ Form::textarea('budget_information', null, ['class' => 'form-control', 'id' => 'budget_information',
                'placeholder' => 'Ex. Conta...', 'rows' => '4', 'wire:model'=>'budget_information']) }}
            </div>

              @error('budget_information')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Informações do certame</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              {{ Form::label('localization', 'Localização:') }}

              {{ Form::text('localization', null, ['class' => 'form-control', 'placeholder' => 'Ex. Comprasnet',
               'wire:model'=>'localization']) }}
              @error('localization')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="row">

              <div class="col">
                <div class="form-group">
                  {{ Form::label('event_date', 'Data do certame:') }}

                  {{ Form::date('event_date', null, ['class' => 'form-control', 'wire:model'=>'event_date']) }}
                  @error('event_date')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  {{ Form::label('event_time', 'Hora do certame:') }}

                  {{ Form::time('event_time', null, ['class' => 'form-control', 'wire:model'=>'event_time']) }}
                  @error('event_time')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>

            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="row">
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Categorização</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">

              {{ Form::label('modality_id', 'Modalidade:') }}

              {{ Form::select('modality_id', $modalities, null,
              ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model'=>'modality_id']) }}
              @error('modality_id')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">

              {{ Form::label('type_id', 'Tipo:') }}

              {{ Form::select('type_id', $types, null, ['placeholder' => 'selecione',
              'class' => 'form-control', 'wire:model'=>'type_id']) }}
              @error('type_id')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">

              {{ Form::label('situation_id', 'Situação:') }}

              {{ Form::select('situation_id', $situations, null, ['placeholder' => 'selecione',
              'class' => 'form-control', 'wire:model'=>'situation_id']) }}
              @error('situation_id')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group">

              {{ Form::label('finality_id', 'Finalidade:') }}

              {{ Form::select('finality_id', $purposes, null, ['placeholder' => 'selecione',
              'class' => 'form-control', 'wire:model'=>'finality_id']) }}
              @error('finality_id')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Publicação</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">

              {{ Form::label('status', 'Status') }}

              {{ Form::select('status', ['1' => 'Publicado', '0' => 'Não publicado'], null,
              ['placeholder' => 'selecione', 'class' => 'form-control', 'wire:model'=>'status']) }}

              @error('status')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>

          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="col-12">
        <div class="card card-secondary">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <a href="{{ route('dashboard.bidding.details', $bidding->id) }}" class="btn btn-secondary">Cancelar</a>
                <button type="button" wire:click="delete" class="btn btn-danger">Deletar</button>

                {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


</div>
{{ Form::close() }}


@section('css')

<style>
  .tox-statusbar__branding {
    display: none;
  }

</style>
@stop

@section('js')

<script src="{{ url('js/tinymce/tinymce.min.js') }}"></script>

<script>
  tinymce.init({
    selector: '#budget_information',
    language: 'pt_BR',
    menubar: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'media table paste code help wordcount'
    ],
    toolbar: 'undo redo | ' +
      'bold italic | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent| table  | help',
    setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
            @this.set('budget_information', editor.getContent());
            });
        },

  });
</script>
<script>
    window.addEventListener('delete', event => {

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
                Livewire.emit('destroy');
            }
        });
    });
</script>
@stop
