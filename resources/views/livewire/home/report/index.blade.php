
<div>
    <div class="container">
        <h2 class="text-uppercase">{{$report->title}}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">{{$report->title}}</li>
            </ol>
          </nav>
          <div class="border-top  border-primary my-1"></div>
        <div class="text-justify">
            {{$report->description}}
        </div>
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Ano:</label>
                            <select class="form-control" style="width: 100%;" name="tipo" wire:model="tipo">
                                <option selected value="">Todos</option>
                                @foreach ($years as $year )
                                    <option value="{{$year->year}}">{{$year->year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="form-group">
                            <label>Titulo:</label>
                            <select class="form-control" style="width: 100%;" name="tipo" wire:model="tipo">
                                <option selected value="">Todos</option>
                                @foreach ($report->reportType->where('status', 1) as $type )
                                    <option value="{{$type->slug}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Publicado em:</label>
                            <input class="form-control" type="date" name="" id="">
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Periodo até:</label>
                            <input class="form-control" type="date" name="" id="">
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

    </div>
</div>
