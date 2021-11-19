<div class="container">

  <div class="row">
    <div class="col-sm-8">

      <div class="bg-primary rounded">
        <div class="d-flex flex-row ">
          <div class="flex-column p-2 pb-0">
            <p class="text-right text-white text-uppercase"><strong>Quantidade de Licitações realizadas em {{ $yearActive->year }}</strong>
            </p>
            <p class="text-right text-white ">{{$yearActive->biddings->where('status', true)->count()}}</p>
          </div>
          <div class="border border-light m-3"></div>
          <div class="flex-column p-2 pb-0">
            <p class="text-right text-white text-uppercase"> <strong>Valor total gasto por meio de Licitacões</strong>
            </p>
            <p class="text-right text-white "> R$ {{number_format($yearActive->biddings->where('status', true)->sum('contracted_value'), 2, ',', '.')}}</p>
          </div>
        </div>

      </div>
    </div>

    {{-- /END/ --}}

    <div class="col-sm-4">
      <p class="text-primary">Escolha o ano desejado:</p>
      <ul class="nav nav-pills">
        @foreach ($years as $year)
          <li class="nav-item m-1">
            <a class="nav-link @if ($yearActive->year == $year->year) active
            @else
              border @endif " aria-current="page"
              href="{{ route('site.bidding.index', $year->year) }}">
              {{ $year->year }}
            </a>
          </li>

        @endforeach

        <li class="nav-item m-1">
          <a href="" class="nav-link border  text-uppercase">Outros</a>
        </li>
      </ul>
    </div>
  </div>

</div>
{{-- /END/ --}}
<div class="my-4"></div>
