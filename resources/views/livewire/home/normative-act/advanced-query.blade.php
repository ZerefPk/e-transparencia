@section('title')
    | Atos Normativos - Consulta Avançada
@stop
@section('meta-description')

    <meta name="description" content="Consulta Avançada">

@stop
<div>
    <div class="container">
        <h2 class="text-uppercase">Atos Normativos</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Atos Normativos</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h5 class="text-primary text-uppercase">
                    Consultas de Atos Normativos
                </h5>
            </div>
            <div class="p-2 text-uppercase ">
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn hover border" data-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            Detalhar <i class="fa fa-arrow-alt-circle-right"></i>
                        </a>
                        <div class="dropdown-menu">
                            @foreach ($types as $type)

                                <a class="dropdown-item"
                                    href="{{ route('site.normativeact.index', $type) }}">{{ $type->type }}</a>

                            @endforeach
                        </div>
                    </li>
                </ul>

            </div>
        </div>
        @if (!$method)
            {!! Form::open(['wire:submit.prevent' => 'setAttr']) !!}

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-uppercase">
                        Para consultar uma
                        @foreach ($types as $type)
                            {{ $type->type }},
                        @endforeach
                        o preencha qualquer um dos campos abaixo e clique em consultar.
                    </h5>
                </div>
                <div class="card-body">

                    <form>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label text-right">
                                Ato Normativo:
                            </label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-control" wire:model="tI">
                                    <option value="">Selecione</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->slug }}">{{ $type->plural }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label text-right">
                                Ano:
                            </label>
                            <div class="col-sm-9">
                                <input class="form-control" name="year" type="text" placeholder="Pesquise por ano..."
                                    wire:model="aI">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-3 col-form-label text-right">
                                Número:
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="resolution" placeholder="EX: 003532"
                                    wire:model="nI">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label text-right">
                                Ementa (palavra-chave):
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ementa"
                                    placeholder="EX: Anuidade ou NBC" wire:model="eI">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-3">
                                <button type="button" class="btn btn-primary" wire.click="refreshQuery">
                                    <i class="fa fa-broom"></i>
                                    Limpar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            {!! Form::open() !!}
        @else
            @if (count($normativesActs) > 0)
                <div class="my-2">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="">
                                <tr>
                                    <th class="text-center align-middle" scope="col">Tipo</th>

                                    <th class="text-center align-middle" scope="col">número</th>
                                    <th class="text-center align-middle" scope="col">Ementa</th>
                                    <th class="text-center align-middle" scope="col">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normativesActs as $normativeAct)
                                    <tr>

                                        <td class="text-center align-middle text-uppercase">
                                            <strong>{{ $normativeAct->type->type}}</strong>
                                        </td>
                                        <td class="text-center align-middle">
                                            <strong>{{ $normativeAct->getRealNumber() }}</strong>
                                        </td>
                                        <td class="align-middle text-break text-justify">
                                            {{ $normativeAct->ementa }}
                                        </td>

                                        </td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-primary"
                                                href="{{ route('site.normativeact.details', $normativeAct) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {!! $normativesActs->links() !!}
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
                                    Não há registros de {{ $typeNormativeAct->type }}
                                </h5>
                            </div>
                        </div>

                    </div>
                @endisset

            @endif
        @endif

</div>
</div>


@push('js')
<script src="{{ url('js/sweetalert.js') }}"></script>
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<x-livewire-alert::scripts />
@endpush
