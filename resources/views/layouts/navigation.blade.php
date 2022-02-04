<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container text-uppercase ">
        <a class="navbar-brand" href="/">
            <img src="{{ asset(config('application.logo_header_img')) }}" width="200"
                alt="{{ config('application.logo__header_img_alt') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                @if (env('APP_DEBUG'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark " href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Instituicional
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="gestao" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestão
                    </a>
                    <div class="dropdown-menu" aria-labelledby="gestao">
                        <a class="dropdown-item" href="#">Pestação de Contas</a>
                        <a class="dropdown-item" href="#">Cargos</a>
                        <a class="dropdown-item" href="#">Funcionarios</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="planejamento" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        planejamento
                    </a>
                    <div class="dropdown-menu" aria-labelledby="planejamento">
                        <a class="dropdown-item" href="#">Pac</a>
                        <a class="dropdown-item" href="#">PDTI</a>
                    </div>
                </li>
                @endif

                @if ($publicationsMenu->count() > 0)
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" id="publication" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    publicações
                  </a>
                  <div class="dropdown-menu" aria-labelledby="publication">
                    @foreach ($publicationsMenu as $publicationItem )
                      <a class="dropdown-item" href="{{route('site.publication.index', $publicationItem)}}">{{$publicationItem->title}}</a>
                    @endforeach
                  </div>
                </li>
                @endif
                @if ($publicationsMenu->count() > 0)
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" id="publication" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Atos Normativo
                  </a>
                  <div class="dropdown-menu" aria-labelledby="publication">
                    <a class="dropdown-item border-bottom" href="{{route('site.normativeact.advancedQuery')}}">Consulta Avançada</a>
                    @foreach ($typesNormativesActsMenu as $typeNormativeActItem )
                      <a class="dropdown-item" href="{{route('site.normativeact.index', $typeNormativeActItem)}}">{{$typeNormativeActItem->type}}</a>
                    @endforeach
                  </div>
                </li>
                @endif

                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="contacts" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contratos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="contacts">
                        <a class="dropdown-item" href="{{ route('site.contract.index') }}">Contratos</a>

                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('site.bidding.index') }}">Licitações</a>

                </li>
                @if (env('APP_DEBUG'))
                <li class="nav-item">
                    <a class="nav-link text-dark" href="">denuncia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="">Perguntas Frequentes</a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
