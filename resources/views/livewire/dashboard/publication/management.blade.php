@section('title', 'Dashboard - Publicação')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Gestão de Publicação</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('dashboard.publication.index')}}">Publicação</a></li></li>
                <li class="breadcrumb-item active">{{$publication->title}}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop
<div>
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
          <h3 class="card-title text-uppercase">{{$publication->title}}</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item border-right"><a
                                    class="nav-link active"
                                    href="#documents" data-toggle="tab">Relatorios Incluidos</a></li>
                            <li class="nav-item border-right"><a
                                    class="nav-link"
                                    href="#category" data-toggle="tab">Titulos de Publicação</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        @livewire('dashboard.publication.document', ['publication' => $publication])
                        @livewire('dashboard.publication.category', ['publication' => $publication])
                    </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h3 class="text-primary text-uppercase">{{$publication->title}}</h3>
              <p class="text-muted text-justify">{{$publication->description}}</p>
              <br>

              <div class="text-center mt-5 mb-3">
                <a href="{{route('dashboard.publication.index')}}" class="btn btn-lg btn-primary"> <i class="fa fa-arrow-left"></i> Voltar</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

</div>
@push('js')

@endpush
