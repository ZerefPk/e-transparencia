@section('title')
| LIC {{ $bidding->year }}/{{ $bidding->number }}
@stop
@section('meta-description')

<meta name="description" content="{{strip_tags(html_entity_decode($bidding->object, ENT_COMPAT, 'UTF-8'))}}">

@stop
@section('container')
  <div class="container">
    <h3 class="text-uppercase">Processo Licitatório: {{ $bidding->year }}/{{ $bidding->number }} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('site.bidding.index', $bidding->year) }}">Licitações {{ $bidding->year }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ $bidding->year }}/{{ $bidding->number }}</li>
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
            <div class="col">
              <p> <strong> Objeto:</strong></p>
              {!! $bidding->object !!}
            </div>
            <div class="d-flex d-row">
              <div class="col-sm-4">
                <p> <strong>Modalidade: </strong>{{ $bidding->modality->category }} </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Tipo: </strong>{{ $bidding->type->category }} </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Situação: </strong>{{ $bidding->situation->category }} </p>
              </div>

            </div>
            <div class="d-flex d-row">
              <div class="col-sm-4">
                <p> <strong>Local: </strong>{{ $bidding->localization }} </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Data do certame: </strong>{{ (isset($bidding->event_date)) ? date('d/m/Y', strtotime($bidding->event_date)) : '-'; }}
                  {{ (isset($bidding->event_time)) ? date('H:i', strtotime($bidding->event_time)) : ''; }}</p>
              </div>
            </div>
            <div class="d-flex d-row">
              <div class="col-sm-4">
                <p> <strong>Valor estimado:
                  </strong>{{ 'R$ ' . number_format($bidding->estimated_value, 2, ',', '.') }}
                </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Valor Contratado:
                  </strong>{{ 'R$ ' . number_format($bidding->contracted_value, 2, ',', '.') }}</p>
              </div>
            </div>
            @if ($bidding->additional)
            <div class="d-flex d-row">
              <div class="col-sm-4">
                <p> <strong>Edital: </strong>{{ $bidding->additional->notice_number }} </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Inicio do acolhimento das propostas: </strong>{{ (isset($bidding->additional->bid_opening_date)) ? date('d/m/Y', strtotime($bidding->additional->bid_opening_date)) : '-'; }}
                  {{ (isset($bidding->additional->bid_opening_hour)) ? date('H:i', strtotime($bidding->additional->bid_opening_hour)) : ''; }} </p>
              </div>
              <div class="col-sm-4">
                <p> <strong>Limite do acolhimento das propostas: </strong>{{ (isset($bidding->additional->bid_closing_date)) ? date('d/m/Y', strtotime($bidding->additional->bid_closing_date)) : '-'; }}
                  {{ (isset($bidding->additional->bid_closing_hour)) ? date('H:i', strtotime($bidding->additional->bid_closing_hour)) : ''; }}</p>
              </div>

            </div>
            @endif

            <div class="card my-4">
              <div class="card-header">
                Anexos
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  @if ($bidding->documents->count()>0)
                  <table class="table table-bordered">
                    <tbody>
                      @foreach ($bidding->documents as $document)
                        <tr>
                          <th scope="row" width="75%">
                            <p>{{ $document->name }}</p>
                          </th>
                          <th class="text-center">
                            <a href="{{ $document->getRealPath() }}" class="btn btn-primary" target="_blank"
                              rel="noopener noreferrer"> <i class="fa fa-file-download"></i> </a>
                          </th>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @else
                  <p class="text-muted">Não há anexos para o Processo:
                    {{ $bidding->getRealNumber() }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="itens">
            @foreach ($bidding->biddingGroups as $biddingGroup)

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr class="text-center">
                      <th colspan="6">Grupo {{ $biddingGroup->number_group }} - {{ $biddingGroup->group_name }}
                      </th>

                    </tr>
                    <tr>

                      <th class="text-center align-middle">Item</th>
                      <th class="text-center align-middle">Descrição</th>
                      <th class="text-center align-middle">Unidade</th>
                      <th class="text-center align-middle">Quantidade</th>
                      <th class="text-center align-middle">Valor Unitario</th>
                      <th class="text-center align-middle">Valor Total</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($biddingGroup->biddindItens as $itemGroup)
                      <tr>

                        <td class="text-center align-middle">{{ $itemGroup->item }}</td>
                        <td class="text-center align-middle">{!! $itemGroup->description !!}</td>
                        <td class="text-center align-middle">{{ $itemGroup->unity }}</td>
                        <td class="text-center align-middle">{{ $itemGroup->quantity }}</td>
                        <td class="text-center align-middle">R$
                          {{ number_format($itemGroup->estimated_total_value / $itemGroup->quantity, 2, ',', '.') }}
                        </td>
                        <td class="text-center align-middle">R$
                          {{ number_format($itemGroup->estimated_total_value, 2, ',', '.') }}</td>




                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            @endforeach
            @if (count($bidding->biddingItens) > 0)
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
                    @foreach ($bidding->biddingItens as $item)
                      <tr>

                        <td class="text-center align-middle">{{ $item->item }}</td>
                        <td class="text-center align-middle">{!! $item->description !!}</td>
                        <td class="text-center align-middle">{{ $item->unity }}</td>
                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                        <td class="text-center align-middle">R$
                          {{ number_format($item->estimated_total_value / $item->quantity, 2, ',', '.') }}</td>
                        <td class="text-center align-middle">R$
                          {{ number_format($item->estimated_total_value, 2, ',', '.') }}</td>




                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @elseif (count($bidding->biddingGroups) <= 0) <p class="text-muted">Não há itens para o Processo:
                {{ $bidding->getRealNumber() }}</p>
            @endif
          </div>

          <div class="tab-pane" id="winners">
            <p class="text-muted">Não há registros para o Processo:
              {{ $bidding->getRealNumber() }}</p>
          </div>

          <div class="tab-pane" id="budget">
            <div class="table-responsive">
              @if (!is_null($bidding->budget_information))
              {!!$bidding->budget_information!!}

              @else
              <p class="text-muted">Não há registro para o Processo:
                {{ $bidding->getRealNumber() }}</p>
              @endif

            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

