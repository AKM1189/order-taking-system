

@section('toast')

<div class="toast position-absolute top-0 end-0" style="z-index: 1050; opacity: 1 !important;" id="toastNotice" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="mr-auto">Category</strong>
    <button type="button" class="ml-2 mb-1 close" data-bs-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
      {{session('category_add_success')}}{{session('category_add_duplicate')}}{{session('category_update_success')}}{{session('category_delete_success')}}{{session('category_delete_fail')}}
  </div>
</div>

<p id="noti" style="display: none">{{session('category_add_success')}}{{session('category_add_duplicate')}}{{session('category_update_success')}}{{session('category_delete_success')}}{{session('category_delete_fail')}}</p>

@endsection