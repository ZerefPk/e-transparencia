@if (session('notificationflashModal'))
@php
    $message = session('notificationflashModal');
@endphp
<div class="modal fade" id="notificationflashModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{($message['title']? $message['title'] : 'Informação' )}}


        </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           {{ $message['message']}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>
@push('js')
<script>

        $('#notificationflashModal').modal('show');



</script>
@endpush
@endif
