@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Licitação</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Licitação</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="row">
    <div class="col-md-4">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buscar:</h3>
            </div>
            <form  method="GET">
                <div class="card-body">

                    <div class="form-group">
                        <label>Ano:</label>
                        <select class="form-control" style="width: 100%;" name="ano">
                            <option selected disabled>Selecione</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" placeholder="Processo ou Objeto" name="q">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Modalidade:</label>
                        <select class="form-control" style="width: 100%;" name="modalidade">
                            <option selected disabled>Modalidade</option>
                            @foreach ($categories->where('type', 'bidding_modality') as $modality)
                                <option value="{{ $modality->slug }}">{{ $modality->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Situação:</label>
                        <select class="form-control" style="width: 100%;" name="situacao">
                            <option selected disabled>Situação</option>
                            @foreach ($categories->where('type', 'bidding_situation') as $situation)
                                <option value="{{ $situation->slug }}">{{ $situation->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo: </label>
                        <select class="form-control" style="width: 100%;" name="tipo">
                            <option selected disabled>Tipo de licitação</option>
                            @foreach ($categories->where('type', 'bidding_type') as $type)
                                <option value="{{ $type->slug }}">{{ $type->category }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="card-footer clearfix">
                    <div class="row">

                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i>
                            Buscar</button>
                    </div>
                </div>
                <!-- /.card-body -->
            </form>
        </div>

    </div>
    <div class="col-md-8">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Todas as licitações</h3>

                <div class="card-tools">
                    <a href="{{ route('dashboard.bidding.create') }}" class="btn btn-primary btn-block"><i
                            class="fa fa-plus"></i>
                        Novo</a>

                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Processo</th>
                            <th>Modalidade</th>
                            <th style="width: 40px">Status</th>
                            <th style="width: 40px">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biddings as $bidding)
                            <tr>
                                <td>{{ $bidding->id }}</td>
                                <td>{{ $bidding->year }}/{{ $bidding->number }}</td>
                                <td>
                                    {{ $bidding->modality->category }}
                                </td>
                                <td>
                                    @if ($bidding->status)
                                        <span class="badge bg-success"> <i class="fa fa-eye"></i></span>
                                    @else
                                        <span class="badge bg-danger"> <i class="fa fa-eye-slash"></i></span>
                                    @endif
                                </td>
                                <td><span class="badge bg-primary"> <a href="">
                                            <i class="fa fa-edit"></i>
                                        </a></span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    {!! $biddings->links() !!}
                </ul>
            </div>
        </div>
        <!-- /.card -->
    </div>

</div>
