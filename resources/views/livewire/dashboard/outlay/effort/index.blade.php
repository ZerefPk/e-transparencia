@section('title', 'Dashboard - Empenhos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Empenhos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Empenhos</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Empenhos:
            </h3>
            <div class="card-tools">
                <a class="btn btn-primary btn-block" href="{{route('dashboard.effort.create')}}"><i class="fa fa-plus"></i>
                    Novo</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Ano</th>
                            <th>Numero</th>
                            <th>Favorecido</th>

                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td colspan="2">
                                <select class="form-control" style="width: 100%;" name="y" wire:model="y">
                                    <option value="" selected>Ano</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year }}">{{ $year->year }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td >
                                <input type="text" class="form-control" wire:model="n" placeholder="Numero do empenho">
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="f" placeholder="Favorecido">
                            </td>

                            <td>
                                <select class="form-control" style="width: 100%;" name="s" wire:model="s">
                                    <option value="" selected>Status</option>
                                    <option value="1">Habilitado</option>
                                    <option value="0" > Desabilitado</option>
                                </select>
                            </td>
                            <td>
                                <button wire:click="refreshQuery()" class="btn btn-warning"><i
                                    class="fa fa-broom"></i>
                                </button>
                            </td>
                        </tr>
                        @forelse ($efforts as $effort)
                            <tr>
                                <th scope="row">
                                    {{ $effort->id }}
                                </th>
                                <td>
                                    {{ $effort->year }}
                                </td>
                                <td>
                                    {{ $effort->number }}
                                </td>
                                <td class="text-uppercase">
                                    {{$effort->provider->corporate_name}}
                                    @if ($effort->provider->type)
                                        - {{ $effort->provider->cnpj }}
                                    @else
                                        - {{ $effort->provider->cpf }}
                                    @endif
                                </td>


                                <td>
                                    {{ $effort->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <a href="{{route('dashboard.effort.edit', $effort->id)}}" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-uppercase">
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
                {!! $efforts->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

</div>

@section('css')

@stop

@section('js')

@stop
