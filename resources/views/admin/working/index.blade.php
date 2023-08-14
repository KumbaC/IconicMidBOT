@extends('admin.layouts.main')
@section('css')
<link href="{{ asset('backend/plugins/custom/datatables/datatables.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">Working List
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.working.create') }}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                        </g>
                    </svg>
                </span>Add New</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-separate table-head-custom table-checkable" id="working">
                <thead>
                    <tr>

                        <th class="mobile tablet desktop">Employee</th>
                        <th class="mobile tablet desktop">Entry date</th>
                        <th class="mobile tablet desktop">Lunch time</th>
                        <th class="mobile tablet desktop">Back Lunch</th>
                        <th class="mobile tablet desktop">Out|End time</th>

                        <th class="not-mobile">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($working as $workings)
                        <tr>
                           {{--  <td>{{ $workings->id }}</td> --}}
                            <td><a href="#">{{ $workings->user->name }}</a></td>

                            <td>{{ date('d/m/y h:i a', strtotime($workings->entry_date)) }}</td>
                            <td>{{ date('h:i a', strtotime($workings->lunch_time)) }}</td>

                            <td>{{ date('h:i a', strtotime($workings->back_lunch)) }}</td>


                            <td>{{ date('d/m/y h:i a', strtotime($workings->out)) }}</td>



                            <td>
                                <a href="{{ route('admin.working.show', Crypt::encrypt($workings->id)) }}" class="btn btn-sm btn-clean btn-icon mr-2" title="See details">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                                <path d="M10.5,10.5 L10.5,9.5 C10.5,9.22385763 10.7238576,9 11,9 C11.2761424,9 11.5,9.22385763 11.5,9.5 L11.5,10.5 L12.5,10.5 C12.7761424,10.5 13,10.7238576 13,11 C13,11.2761424 12.7761424,11.5 12.5,11.5 L11.5,11.5 L11.5,12.5 C11.5,12.7761424 11.2761424,13 11,13 C10.7238576,13 10.5,12.7761424 10.5,12.5 L10.5,11.5 L9.5,11.5 C9.22385763,11.5 9,11.2761424 9,11 C9,10.7238576 9.22385763,10.5 9.5,10.5 L10.5,10.5 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg>
                                    </span>
                                 </a>


                                <a href="{{ route('admin.working.edit', Crypt::encrypt($workings->id)) }}" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                                    <span class="svg-icon svg-icon-md">
                                       <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                             <rect x="0" y="0" width="24" height="24"></rect>
                                             <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                             <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                          </g>
                                       </svg>
                                    </span>
                                 </a>

                                <a href="#" data-toggle="modal" data-target="#kt_modal_delete{{ $workings->id }}" class="btn btn-sm btn-clean btn-icon" title="Delete" id="delete_btn">
                                    <span class="svg-icon svg-icon-md">
                                       <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                             <rect x="0" y="0" width="24" height="24"></rect>
                                             <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                             <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                          </g>
                                       </svg>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
    @foreach($working as $key => $value)
		<div class="modal fade" id="kt_modal_delete{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				{!! Form::open(['route' => ['admin.working.destroy', encrypt($value->id)], 'method' => 'DELETE','id'=>"form_eliminar"]) !!}
					{{ csrf_field() }}
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Delete working time</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<p class="text-center">Do you really want to delete this working?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Delete</button>
						</div>
					</div>
                {!! Form::close() !!}
			</div>
		</div>
	@endforeach
@endsection
@section('js')
<script src="{{ asset('backend/plugins/custom/datatables/datatables.bundle.js?v=7.0.5') }}"></script>
<script src="{{ asset('backend/js/pages/crud/datatables/basic/basic.js?v=7.0.5') }}"></script>
<script src="{{ asset('backend/js/pages/crud/datatables/extensions/responsive.js?v=7.0.5') }}"></script>
<script>
    $(document).ready(function() {
        $('#working').DataTable({
            responsive: true,
            autowidth: false,
            order: [[0, 'desc']],
        });
    } );
</script>
<script>
    $(document).ready(function(){
        $("#delete_btn").click(function(){
            $("#delete_form").submit();
        });
    });
</script>
@endsection
