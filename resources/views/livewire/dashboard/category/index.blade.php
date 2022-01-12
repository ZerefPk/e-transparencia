@section('title', 'Dashboard - Categorias')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Categorias</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Categoria</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Categorias:
            </h3>
            <div class="card-tools">
                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#create-category"
                    data-backdrop="static"><i class="fa fa-plus"></i>
                    Novo</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Categoria</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td>
                                    {{ $category->category }}
                                </td>
                                <td>
                                    @foreach ($types as $key => $type)
                                        @foreach ($type as $itemKey => $item)
                                            @if ($category->type == $itemKey)
                                                {{ $key . ': ' . $item }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    {{ $category->status ? 'Ativo' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-uppercase">
                                    não há registro para o filtro de busca aplicado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
            </ul>
        </div>
    </div>
    <!-- /.card -->
    @livewire('dashboard.category.create')
</div>

@section('css')

@stop

@section('js')

@stop
