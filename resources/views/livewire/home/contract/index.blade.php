@section('title')
    | Contratos
@stop
@section('meta-description')

    <meta name="description" content="Contratos">

@stop
<div>
    <div class="container">
        <h2 class="text-uppercase">Contratos</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Contratos</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h5 class="text-primary text-uppercase">
                    Visão geral dos contratos
                </h5>
            </div>
            <div class="p-2">
                <a href="{{route('site.contract.statistic')}}" class="text-uppercase btn hover border">
                    Ver estatísticas <i class="fa fa-arrow-alt-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Ano:</label>
                            <select class="form-control" style="width: 100%;" name="ano" wire:model="a">
                                <option selected value="">Todos</option>
                                @foreach ($years as $year )
                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="form-group">
                            <label>Busca: </label>
                            <input class="form-control" type="text" placeholder="Numero, objeto ou fornecedor" wire:model="q">

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Situação:</label>
                            <select class="form-control" style="width: 100%;" name="situation" wire:model="s">
                                <option selected value="">Todos</option>
                                @foreach ($situations as $situation )
                                    <option value="{{$situation->slug}}">{{$situation->category}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Assunto:</label>
                            <select class="form-control" style="width: 100%;" name="subject" wire:model="f">
                                <option selected value="">Todos</option>
                                @foreach ($subjects as $subject )
                                    <option value="{{$subject->slug}}">{{$subject->category}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Limpar:</label>
                            <button type="button" class="btn btn-primary" style="width: 100%;" wire:click="refreshQuery">
                                <i class="fa fa-broom"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($contracts->count() > 0)
            <div class="my-2">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center align-middle" scope="col">Contrato Nº.</th>
                                <th class="text-center align-middle" scope="col">Objeto</th>
                                <th class="text-center align-middle" scope="col">Fornecedor</th>
                                <th class="text-center align-middle" scope="col">Valor</th>

                                <th class="text-center align-middle" scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $contract)
                                <tr>

                                    <td class="text-center align-middle">
                                        <strong>{{ $contract->getRealNumber() }}</strong>
                                    </td>
                                    <td class="align-middle text-break text-justify">
                                        {{ $contract->object }}
                                    </td>
                                    <td class="text-break align-middle text-justify">
                                        {{ $contract->provider->corporate_name }} -
                                        {{ $contract->provider->type ? $contract->provider->cnpj : $contract->provider->cpf }}

                                    </td>

                                    <td class="text-center align-middle">
                                        R$: {{ number_format($contract->overall_contract_value, 2, ',', '.') }}

                                    </td>
                                    <td class="text-center align-middle">
                                        @if (count($listSearch) > 0)
                                        <a class="btn btn-primary"
                                            href="{{route('site.contract.details', $contract->contract->slug)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @else
                                        <a class="btn btn-primary"
                                            href="{{route('site.contract.details', $contract->slug)}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $contracts->links() !!}
            </div>

        @else
            @if (count($listSearch) > 0)
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros para a busca
                                realizada:
                            </h5>
                            <ul class="text-uppercase">
                                @foreach ($listSearch as $search)
                                    <li class="text-break">
                                        <strong>
                                            {{ $search['field'] }}:
                                        </strong>
                                        {{ $search['value'] }}


                                    </li>
                                @endforeach
                            </ul>
                            <button class=" btn btn-primary text-uppercase" wire:click="refreshQuery">
                                <i class="fa fa-arrow-left"></i> voltar</button>
                        </div>

                    </div>

                </div>
            @else
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros de contratos
                            </h5>
                        </div>
                    </div>

                </div>
            @endisset

        @endif
</div>

</div>
