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
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="basicInformation">
                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Número do Termo:</strong>
                                <p class="text-uppercase">  {{ $contract->getRealNumber() }} </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Número do Processo: </strong>
                                <p class="text-uppercase">  {{ $contract->process_number }}</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Situação: </strong>
                                <p class="text-uppercase">  {{ $contract->situation->category }}</p>
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

                                <strong class="text-uppercase">Fornecedor: </strong>
                                <p class="text-uppercase">
                                    {{ $contract->provider->corporate_name }}
                                    <i class="fa fa-eye" data-toggle="modal" data-target="#provider"></i>
                                </p>


                            </div>
                            <div class="col-sm-4">
                                <strong>{{ $contract->provider->type ? 'CNPJ' : 'CPF' }}: </strong>
                                <p class="text-uppercase">
                                    {{ $contract->provider->type ? $contract->provider->cnpj : $contract->provider->cpf }}
                                </p>
                            </div>

                        </div>

                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                 <strong class="text-uppercase">Assinatura do Contrato: </strong>
                                 <p > {{ date('d/m/Y', strtotime($contract->signature_date)) }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">inicio da Vigência:
                                </strong>
                                <p> {{ date('d/m/Y', strtotime($contract->start_validity)) }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">término da Vigência:
                                    </strong>
                                <p> {{ date('d/m/Y', strtotime($contract->end_term)) }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                 <strong class="text-uppercase">Valor do Contrato:</strong>
                                 <p>
                                   R$: {{ number_format($contract->overall_contract_value, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Forma de Contratação:</strong>

                                <p class="text-uppercase">
                                    {{ $contract->formContract->category }}
                                </p>

                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Licitação:</strong>
                                @if ($contract->bidding)
                                    <p>
                                        {{ $contract->bidding->getRealNumber() }}
                                        <a href="{{route('site.bidding.index',$contract->bidding->slug)}}" target="_blank"><i class="fa fa-link"></i></a>

                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex d-row">
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Gestor:</strong>
                               <p class="text-uppercase">{{ $contract->contract_manager }}</p>
                            </div>
                            <div class="col-sm-4">
                                <strong class="text-uppercase">Fiscal:</strong>
                                <p class="text-uppercase">{{ $contract->contract_tax }}</p>

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

                                                <th scope="row" class="text-center align-middle">{{ $item->item }}</th>
                                                <td class="text-center align-middle">{!! $item->description !!}</td>
                                                <td class="text-center align-middle">{{ $item->unity }}</td>
                                                <td class="text-center align-middle">{{ $item->quantity }}</td>
                                                <td class="text-center align-middle">R$
                                                    {{ number_format($item->unity_value, 2, ',', '.') }}
                                                </td>
                                                <td class="text-center align-middle">R$
                                                    {{ number_format($item->total_value, 2, ',', '.') }}
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


                </div>
            </div>

        </div>
        <div class="card my-4">
            <div class="card-header">
                <h5 class="card-title text-uppercase">Documentos Anexados</h5>
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
                                        <td class="text-center">
                                            <a href="{{ $document->getRealPath() }}"
                                                class="btn btn-primary" target="_blank"
                                                rel="noopener noreferrer"> <i
                                                    class="fa fa-file-download"></i> </a>
                                        </td>
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
        <div class="card my-4">
            <div class="card-header">
                <h5 class="card-title text-uppercase">Empenhos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if (count($efforts))
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-uppercase text-center">
                                    <th>
                                        Empenho
                                    </th>
                                    <th>
                                        Data do empenho
                                    </th>
                                    <th>
                                        Tipo de empenho
                                    </th>
                                    <th>
                                        Valor do empenho
                                    </th>
                                    <th>
                                        Ação
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($efforts as $effort)
                                    <tr class="text-center">
                                        <th scope="row">
                                            {{$effort->number_effort}}
                                        </th>
                                        <td>
                                            {{date('m/d/Y', strtotime($effort->date_effort))}}
                                        </td>
                                        <td>
                                            {{$effort->type()}}
                                        </td>
                                        <td>
                                            R$ {{number_format($effort->total_value,2 , ',', '.')}}
                                        </td>
                                        <td >
                                            <a href="{{$effort->getRealPath()}}" target="_blank" class="btn btn-primary">
                                                <i class="fa fas fa-file-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Não há empenhos para o Contrato:
                            {{ $contract->getRealNumber() }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card my-4">
            <div class="card-header">
                <h5 class="card-title text-uppercase">Andamentos</h5>
            </div>
            <div class="card-body">
                @if (count($additives) > 0)
                        @foreach ($additives as $additive)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex d-row">
                                    <div class="col-sm-4">
                                         <strong class="text-uppercase">Sequência: </strong>
                                         <p > {{ $additive->sequence }}
                                        </p>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="text-uppercase">Descrição:
                                        </strong>
                                        <p class="text-break text-justify"> {{ $additive->description }}
                                        </p>
                                    </div>

                                </div>
                                <div class="d-flex d-row">
                                    <div class="col-sm-4">
                                         <strong class="text-uppercase">Assinatura do Contrato: </strong>
                                         <p > {{ date('d/m/Y', strtotime($additive->signature_date)) }}
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong class="text-uppercase">inicio da Vigência:
                                        </strong>
                                        <p> {{ date('d/m/Y', strtotime($additive->start_validity)) }}
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong class="text-uppercase">término da Vigência:
                                            </strong>
                                        <p> {{ date('d/m/Y', strtotime($additive->end_term)) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex d-row">
                                    <div class="col-sm-4">
                                        <strong class="text-uppercase">Tipo </strong>
                                        @if ($additive->type_modification == 3)
                                           <p class="text-uppercase">Recisção Contatual</p>
                                        @elseif($additive->type_modification == 0)
                                        <p class="text-uppercase">Inicial</p>
                                        @else
                                            <p class="text-uppercase">Aditivo Contratual</p>

                                        @endif
                                        </p>
                                    </div>
                                    @if($additive->type_modification != 0)
                                    <div class="col-sm-4">
                                        <strong class="text-uppercase">Valor
                                            @if ($additive->type_modification == 1)
                                                de acréscimo
                                            @elseif($additive->type_modification == 2)
                                                de decréscimo
                                            @else
                                                da recisão
                                            @endif
                                            :
                                        </strong>
                                        <p> R$:
                                            @if ($additive->type_modification == 1)
                                                {{ number_format($additive->addition_value, 2, ',', '.') }}
                                            @elseif($additive->type_modification == 2)
                                                {{ number_format($additive->decrease_value, 2, ',', '.') }}
                                            @else
                                                {{ number_format($additive->termination_value, 2, ',', '.') }}
                                            @endif

                                        </p>
                                    </div>
                                    @endif
                                    <div class="col-sm-4">
                                        <strong class="text-uppercase">Valor do contrato:
                                            </strong>
                                        <p> R$: {{ number_format($additive->total_value, 2, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class="my-2"></div>

                        @endforeach
                    @else
                        <p class="text-muted">Não há aditivos para o Contrato:
                            {{ $contract->getRealNumber() }}</p>
                    @endif
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
