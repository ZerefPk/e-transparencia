@section('title')
    | Contrato - {{ $contract->getRealNumber() }}
@stop
@section('meta-description')

    <meta name="description" content="{{ $contract->object }}">

@stop

<div>
    <div class="container">
        <h3 class="text-uppercase">Contrato: {{ $contract->getRealNumber() }} </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('site.contract.index') }}">Contratos</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $contract->getRealNumber() }}
                </li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-4"></div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#basicInformation" data-toggle="tab">Informações Basicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#itens" data-toggle="tab">Itens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#winners" data-toggle="tab">Ganhadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#budget" data-toggle="tab">Palenjamento e Orçamento</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="basicInformation">
                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                <p class="text-uppercase"> <strong>Número do Termo:</strong> {{ $contract->getRealNumber() }} </p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-uppercase"> <strong>Número Contrato: </strong> {{ $contract->process_number }}</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-uppercase"> <strong>Situação: </strong> {{ $contract->situation->category }}</p>
                            </div>

                        </div>
                        <div class="col">
                            <strong class="text-uppercase"> Objeto:</strong>
                            <p class="text-break text-justify">
                                {{ $contract->object }}
                            </p>
                        </div>
                        <div class="d-flex d-row">
                            <div class="col-sm-6">
                                <div class="d-flex">
                                    <p class="text-uppercase">
                                        <strong>Fornecedor: </strong> {{ $contract->provider->corporate_name }}
                                        <i class="fa fa-eye" data-toggle="modal" data-target="#provider"></i>
                                    </p>


                                </div>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-uppercase"> <strong>{{ $contract->provider->type ? 'CNPJ' : 'CPF' }}: </strong>
                                    {{ $contract->provider->type ? $contract->provider->cnpj : $contract->provider->cpf }}
                                </p>
                            </div>

                        </div>

                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                 <strong class="text-uppercase">Data da Assinatura do Contrato: </strong>
                                 <p > {{ date('d/m/Y', strtotime($contract->signature_date)) }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Data do inicio do contrato:
                                </strong>
                                <p> {{ date('d/m/Y', strtotime($contract->start__validity)) }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Data do fim do contrato:
                                    </strong>
                                <p> {{ date('d/m/Y', strtotime($contract->end_term)) }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                 <strong>Valor do Contrato:</strong>
                                 <p>
                                   R$: {{ number_format($contract->overall_contract_value, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <p></p>
                            </div>
                        </div>


                        <div class="card my-4">
                            <div class="card-header">
                                Anexos
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if ($contract->documents->count() > 0)
                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach ($contract->documents as $document)
                                                    <tr>
                                                        <th scope="row" width="75%">
                                                            <p>{{ $document->name }}</p>
                                                        </th>
                                                        <th class="text-center">
                                                            <a href="{{ $document->getRealPath() }}"
                                                                class="btn btn-primary" target="_blank"
                                                                rel="noopener noreferrer"> <i
                                                                    class="fa fa-file-download"></i> </a>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-muted">Não há anexos para o Contrato:
                                            {{ $contract->getRealNumber() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="itens">
                        @if (count($contract->contractItens) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            </th>
                                            <th class="text-center align-middle">Item</th>
                                            <th class="text-center align-middle">Descrição</th>
                                            <th class="text-center align-middle">Unidade</th>
                                            <th class="text-center align-middle">Quantidade</th>
                                            <th class="text-center align-middle">Valor Unitario</th>
                                            <th class="text-center align-middle">Valor Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contract->contractItens as $item)
                                            <tr>

                                                <td class="text-center align-middle">{{ $item->item }}</td>
                                                <td class="text-center align-middle">{!! $item->description !!}</td>
                                                <td class="text-center align-middle">{{ $item->unity }}</td>
                                                <td class="text-center align-middle">{{ $item->quantity }}</td>
                                                <td class="text-center align-middle">R$
                                                    {{ number_format($item->estimated_total_value / $item->quantity, 2, ',', '.') }}
                                                </td>
                                                <td class="text-center align-middle">R$
                                                    {{ number_format($item->estimated_total_value, 2, ',', '.') }}
                                                </td>




                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif (count($contract->contractItens) <= 0) <p class="text-muted">Não há itens para o
                                Contrato:
                                {{ $contract->getRealNumber() }}</p>
                        @endif
                    </div>

                    <div class="tab-pane" id="winners">
                        <p class="text-muted">Não há registros para o Contrato:
                            {{ $contract->getRealNumber() }}</p>
                    </div>

                    <div class="tab-pane" id="budget">
                        <div class="table-responsive">


                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal" id="provider" tabindex="-1" role="dialog" aria-labelledby="providerLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="providerLabel">Fornecedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-uppercase">
                    <strong>Razão Social: </strong>
                    <p>{{ $contract->provider->corporate_name }}</p>
                    @if ($contract->provider->type)
                        <strong>Nome Fantasia: </strong>
                        <p>{{ $contract->provider->fantasy_name }}</p>
                        <div class="row">
                            <div class="col">
                                <strong>CNPJ: </strong>
                                <p>{{ $contract->provider->cnpj }}</p>
                            </div>
                            <div class="col">

                                <strong>Tipo: </strong>
                                <p>{{ $contract->provider->headquarters ? 'Matriz' : 'Filial' }}</p>
                            </div>
                            <div class="col">

                                <strong>Empresa MEI: </strong>
                                <p>{{ $contract->provider->mei_company ? 'Sim' : 'Não' }}</p>
                            </div>

                        </div>

                    @else
                    <div class="row">
                        <div class="col">
                            <strong>CPF: </strong>
                        <p>{{ $contract->provider->cpf }}</p>
                        </div>
                        <div class="col">
                            <strong>Empresa MEI: </strong>
                            <p>{{ $contract->provider->mei_company ? 'Sim' : 'Não' }}</p>
                        </div>
                    </div>


                    @endif

                    <strong>Natureza Jurídica: </strong>
                    <p>{{ $contract->provider->legal_nature }}</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
</div>
