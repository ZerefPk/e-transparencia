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

                                <a class="dropdown-item" href="{{route('site.normativeact.index', $type)}}">{{ $type->type }}</a>

                            @endforeach
                        </div>
                    </li>
                </ul>

            </div>
        </div>
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
                            <select name="" id="" class="form-control">
                                <option value="">Selecione</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->slug }}">{{ $type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label text-right">
                            Ano:
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" name="year" type="text" placeholder="Pesquise por ano...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label text-right">
                            Número:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="resolution" placeholder="EX: 003532">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label text-right">
                            Ementa (palavra-chave):
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ementa"
                                placeholder="EX: Anuidade ou NBC">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-3">
                            <button type="reset" class="btn btn-primary">
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
    </div>
</div>


