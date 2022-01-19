@section('title', 'Dashboard - Contratos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Contratos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Contratos</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <div class="card card-primary card-outline">
        <div class="card-header">

            <h3 class="card-title">Contratos:
            </h3>
            <div class="card-tools">
                <a class="btn btn-primary btn-block" href="{{route('dashboard.contract.create')}}"><i class="fa fa-plus"></i>
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
                            <th>Fornecedor</th>

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
                                <input type="text" class="form-control" wire:model="n" placeholder="Numero do Contrato">
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="f" placeholder="Fornecedor">
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
                        @forelse ($contracts as $contract)
                            <tr>
                                <td>
                                    {{ $contract->id }}
                                </td>
                                <td>
                                    {{ $contract->year }}
                                </td>
                                <td>
                                    {{ $contract->number }}
                                </td>
                                <td class="text-uppercase">
                                    {{$contract->provider->corporate_name}}
                                    @if ($contract->provider->type)
                                        - {{ $contract->provider->cnpj }}
                                    @else
                                        - {{ $contract->provider->cpf }}
                                    @endif
                                </td>

                                <td>
                                    {{ $contract->status ? 'Habilitado' : 'Desabilitado' }}
                                </td>
                                <td>
                                    <button class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
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
                {!! $contracts->links() !!}
            </ul>
        </div>
    </div>
    <!-- /.card -->

</div>

@section('css')

@stop

@section('js')

@stop
