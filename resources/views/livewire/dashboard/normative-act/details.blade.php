@section('title', 'Dashboard - Ato Normativo ')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Ato Normativos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Ato Normativo</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3 class="text-center text-uppercase">{{ $normativeAct->type->type }}
                    {{ $normativeAct->getRealNumber() }}</h3>

                <p class="text-muted text-center"></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Ementa: </b>
                        <p class="text-justify text-break">{{ $normativeAct->ementa }}</p>

                    </li>
                    <li class="list-group-item">
                        <b>Em vigor: </b>
                        @if ($normativeAct->active)
                            Sim
                        @else
                            Não
                        @endif

                    </li>
                    <li class="list-group-item">
                        <b>Alterada: </b>
                        @if ($normativeAct->altered)
                            Sim
                        @else
                            Não
                        @endif

                    </li>
                    <li class="list-group-item">
                        <b>Revogada: </b>
                        @if ($normativeAct->revoked)
                            Sim
                        @else
                            Não
                        @endif

                    </li>
                    <li class="list-group-item">
                        <b>Status: </b>
                        @if ($normativeAct->status)
                            Habilitado
                        @else
                            Desabilitado
                        @endif

                    </li>
                </ul>

                <a href="{{ route('dashboard.nomativesacts.edit', $normativeAct->id) }}"
                    class="btn btn-primary btn-block"><i class="fa fa-edit"></i> <b> Editar</b></a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- About Me Box -->
        <div class="card card-primary">

            <!-- /.card-header -->
            <div class="card-body">

                <strong class="text-uppercase"><i class="fas fa-calendar mr-1"></i> Data da publicação</strong>

                <p class="text-muted"> {{ date('d/m/Y', strtotime($normativeAct->publication_date)) }}</p>
                <hr>
                @if (isset($normativeAct->path_doc))
                    <a href="{{ $normativeAct->getPathDoc() }}" target="_blank" class="btn btn-lg btn-primary">
                        <i class="fa fas fa-file-word"></i>
                    </a>
                @endif
                @if (isset($normativeAct->path_pdf))
                    <a href="{{ $normativeAct->getPathPdf() }}" target="_blank" class="btn btn-lg btn-primary">
                        <i class="fa fas fa-file-pdf"></i>
                    </a>
                @endif





            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <h5 class="card-title">Alteração e Revogação</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-6">
                        <h5>Esse ATO altera:</h5>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div wire:ignore>

                                        <select class="form-control" id="altered-select" style="width: 100%">
                                            <option selected disabled>Selecione</option>
                                            @foreach ($canAltered as $data)
                                                <optgroup label="{{ $data->type }}">
                                                    @foreach ($data->noramtivesActs->where('id', '!=', $normativeAct->id)->where('year', '<=', $normativeAct->year)->where('status', true)
    as $item)
                                                        <option value="{{ $item->id }}">{{ $item->type->type }} -
                                                            {{ $item->getRealNumber() }}</option>
                                                    @endforeach

                                                </optgroup>

                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary" type="button" wire:click="setAltered"> <i
                                        class="fa fa-plus"></i> Atribuir</button>
                            </div>
                            <div class="col-sm-12">
                                @error('altered_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ATO</th>
                                        <th>AÇÂO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ( $listAltered as $altered )
                                        <tr>
                                            <th scope="row">{{ $altered->normativesActs->id }}</th>
                                            <td>{{ $altered->normativesActs->type->type }} -
                                                {{ $altered->normativesActs->getRealNumber() }}</td>
                                            <td>
                                                <Button type="button" class="btn btn-danger" wire:click="removeAltered({{$altered->id}})">
                                                    <i class="fa fa-trash">

                                                    </i>
                                                </Button>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="3">Sem dados</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>Esse ATO Revoga:</h5>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div wire:ignore>

                                        <select class="form-control" id="revoked-select" style="width: 100%">
                                            <option selected disabled>Selecione</option>
                                            @foreach ($canRevoked as $data)
                                                <optgroup label="{{ $data->type }}">
                                                    @foreach ($data->noramtivesActs->where('id', '!=', $normativeAct->id)->where('year', '<=', $normativeAct->year)->where('status', true)
    as $item)
                                                        <option value="{{ $item->id }}">{{ $item->type->type }}
                                                            -
                                                            {{ $item->getRealNumber() }}</option>
                                                    @endforeach

                                                </optgroup>

                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary" type="button" wire:click="setRevoked"> <i
                                        class="fa fa-plus"></i> Atribuir</button>
                            </div>
                            <div class="col-sm-12">
                                @error('revoked_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ATO</th>
                                        <th>AÇÂO</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ( $listRevoked as $revoked)

                                        <tr>
                                            <th scope="row">{{ $revoked->normativesActs->id }}</th>
                                            <td>{{ $revoked->normativesActs->type->type }} -
                                                {{ $revoked->normativesActs->getRealNumber() }}</td>
                                            <td>
                                                <Button type="button" class="btn btn-danger" wire:click="removeRevoked({{$revoked->id}})">
                                                    <i class="fa fa-trash">

                                                    </i>
                                                </Button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Sem dados</td>
                                        </tr>
                                    @endforelse

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>



@section('css')
    <link rel="stylesheet" href="{{ url('css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}">
@stop

@push('js')
    <script src="{{ url('js/select2.min.js') }}"></script>

    <script>
        $('#altered-select').select2({
            theme: 'bootstrap4',
        })
        $('#altered-select').on('change', function(e) {
            var data = $('#altered-select').select2("val");
            @this.set('altered_id', data);
        });
    </script>
    <script>
        $('#revoked-select').select2({
            theme: 'bootstrap4',
        })
        $('#revoked-select').on('change', function(e) {
            var data = $('#revoked-select').select2("val");
            @this.set('revoked_id', data);
        });
    </script>
@endpush()
