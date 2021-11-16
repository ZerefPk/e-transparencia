@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Licitação</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Licitação</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

<div class="card card-primary card-outline">
    <div class="card-header">

        <h3 class="card-title">Licitações:
        </h3>

        <div class="card-tools">
            <a href="{{ route('dashboard.bidding.create') }}" class="btn btn-primary btn-block"><i
                    class="fa fa-plus"></i>
                Novo</a>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Processo</th>
                        <th>Modalidade</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> #</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" style="width: 100%;" name="modality" wire:model="year">
                                        <option value="" selected>Ano</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{ $year->year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Processo" wire:model="number">
                                </div>
                            </div>
                        </td>
                        <td>

                            <select class="form-control" style="width: 100%;" name="modality" wire:model="modality">
                                <option value="" selected>Modalidade</option>
                                @foreach ($categories->where('type', 'bidding_modality') as $modality)
                                    <option value="{{ $modality->slug }}">{{ $modality->category }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="status" class="form-control" style="width: 100%;" wire:model="status">
                                <option value="">status</option>
                                <option value="1">Publicado</option>
                                <option value="0">Não publicado</option>
                            </select>
                        </td>
                        <td>
                            <button wire:click="resetPage()" class="btn btn-warning"><i
                                    class="fa fa-broom"></i>
                            </button>
                        </td>
                    </tr>
                    @forelse ($biddings as $bidding)
                        <tr>
                            <td class="text-center">{{ $bidding->id }}</td>
                            <td  class="text-center">{{ $bidding->year }}/{{ $bidding->number }}</td>
                            <td  class="text-center">
                                {{ $bidding->modality->category }}
                            </td>
                            <td class="text-center">
                                @if ($bidding->status)
                                    <span class="badge bg-success"> <i class="fa fa-eye"></i></span>
                                @else
                                    <span class="badge bg-danger"> <i class="fa fa-eye-slash"></i></span>
                                @endif
                            </td>
                            <td  class="text-center"><span class="badge bg-primary"> <a href="{{route('dashboard.bidding.edit', $bidding->id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a></span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-uppercase">
                                não há registro para o filtro de busca aplicado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            {!! $biddings->links() !!}
        </ul>
    </div>
</div>
<!-- /.card -->
@section('css')

@stop
