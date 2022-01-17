<div>
    <div class="container">
        <h2 class="text-uppercase">{{ $publication->title }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $publication->title }}</li>
            </ol>
        </nav>
        <div class="border-top  border-primary my-1"></div>
        <div class="text-justify">
            {{ $publication->description }}
        </div>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Ano:</label>
                            <select class="form-control" style="width: 100%;" name="ano" wire:model="a">
                                <option selected value="">Todos</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="form-group">
                            <label>Titulo:</label>
                            <select class="form-control" style="width: 100%;" name="t" wire:model="t">
                                <option selected value="">Todos</option>
                                @foreach ($publication->publicationType->where('status', 1) as $type)
                                    <option value="{{ $type->slug }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Período de:</label>
                            <input class="form-control" type="date" wire:model="i">
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Período até:</label>
                            <input class="form-control" type="date" wire:model="f">
                        </div>

                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label>Limpar:</label>
                            <button type="button" class="btn btn-primary" style="width: 100%;" wire:click="resetAttr">
                                <i class="fa fa-broom"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($documents->count() > 0)
            <div class="my-2">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center align-middle" scope="col">Ano</th>
                                <th class="text-center align-middle" scope="col">Titulo</th>
                                <th class="text-center align-middle" scope="col">Descrição</th>
                                <th class="text-center align-middle" scope="col">Data da Publicação</th>

                                <th class="text-center align-middle" scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td class="text-center align-middle">
                                        <strong>{{ $document->year }}</strong>
                                    </td>
                                    <td class="align-middle text-break text-justify">
                                        {{ $document->type->type }}
                                    </td>
                                    <td class="text-break text-justify">
                                        {{ $document->description }}
                                    </td>

                                    <td class="text-center align-middle">
                                        {{ date('d/m/Y', strtotime($document->publication_date)) }}

                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" target="_blank" href="{{$document->getRealPath()}}">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {!! $documents->links() !!}
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
                            <button class=" btn btn-primary text-uppercase" wire:click="resetAttr">
                                <i class="fa fa-arrow-left"></i> voltar</button>
                        </div>

                    </div>

                </div>
            @else
                <div class="container">
                    <div class="card my-5">
                        <div class="card-body">
                            <h5 class="text-uppercase">
                                Não há registros de publicações
                            </h5>
                        </div>
                    </div>

                </div>
            @endisset

        @endif
</div>

</div>
