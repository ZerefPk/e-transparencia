
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

<div class="card card-primary card-outline">
    <div class="card-header">

        <h3 class="card-title">Licitações:
        </h3>

        <div class="card-tools">
            <a href="{{ route('dashboard.bidding.create') }}" class="btn btn-primary btn-block"><i
                    class="fa fa-plus"></i>
                Novo</a>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Categoria</th>
                        <th>Modalidade</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($biddings = ['a'] as $bidding)

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

@section('css')

@stop

@section('js')

@stop
