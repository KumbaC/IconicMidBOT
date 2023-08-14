@extends('admin.layouts.main')
@section('css')

@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">Add Position
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.positions.index') }}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M11.5,5 L18.5,5 C19.3284271,5 20,5.67157288 20,6.5 C20,7.32842712 19.3284271,8 18.5,8 L11.5,8 C10.6715729,8 10,7.32842712 10,6.5 C10,5.67157288 10.6715729,5 11.5,5 Z M5.5,17 L18.5,17 C19.3284271,17 20,17.6715729 20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 C4,17.6715729 4.67157288,17 5.5,17 Z M5.5,11 L18.5,11 C19.3284271,11 20,11.6715729 20,12.5 C20,13.3284271 19.3284271,14 18.5,14 L5.5,14 C4.67157288,14 4,13.3284271 4,12.5 C4,11.6715729 4.67157288,11 5.5,11 Z" fill="#000000" opacity="0.3"/>
                            <path d="M4.82866499,9.40751652 L7.70335558,6.90006821 C7.91145727,6.71855155 7.9330087,6.40270347 7.75149204,6.19460178 C7.73690043,6.17787308 7.72121098,6.16213467 7.70452782,6.14749103 L4.82983723,3.6242308 C4.62230202,3.44206673 4.30638833,3.4626341 4.12422426,3.67016931 C4.04415337,3.76139218 4,3.87862714 4,4.00000654 L4,9.03071508 C4,9.30685745 4.22385763,9.53071508 4.5,9.53071508 C4.62084305,9.53071508 4.73759731,9.48695028 4.82866499,9.40751652 Z" fill="#000000"/>
                        </g>
                    </svg>
                </span>View List</a>
                <!--end::Button-->
            </div>
        </div>
        {!! Form::model($position, ['route' => ['admin.positions.update', Crypt::encrypt($position->id)], 'method' => 'put', 'id' => 'add_positions']) !!}
			{{ csrf_field() }}

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label class="col-form-label">Name of position <span class="asterisk-required">*</span></label>
                        {!! Form::text('name', null,  array('class'=>'form-control', 'id'=>'name')) !!}
                    </div>


                </div>
                <div class="row">

                    <div class="form-group col-6">
                        <label class="col-form-label">First Payment <span class="asterisk-required">*</span></label>
                        {!! Form::number('first_payment', null, array('class'=>'form-control', 'id'=>'first_payment', 'min'=>1, 'max'=>31)) !!}
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label">Second Payment <span class="asterisk-required">*</span></label>
                        {!! Form::number('second_payment', null, array('class'=>'form-control', 'id'=>'second_payment', 'min'=>1, 'max'=>31)) !!}
                    </div>


                </div>

                <div class="row">

                    <div class="form-group col-6">
                        <label class="col-form-label">Start time <span class="asterisk-required">*</span></label>
                        {!! Form::time('start_time', null, array('class'=>'form-control', 'id'=>'name')) !!}
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label">End time <span class="asterisk-required">*</span></label>
                        {!! Form::time('end_time', null, array('class'=>'form-control', 'id'=>'name')) !!}
                    </div>


                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label class="col-form-label">Description <span class="asterisk-required">*</span></label>
                        {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'size' => '50x4')) !!}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <!--<button type="reset" class="btn btn-success mr-2 pull-left">Back</button>-->
                        <button type="submit" class="btn btn-primary font-weight-bolder mr-2 float-right">Save</button>
                    </div>
                </div>
            </div>
        {!! Form::close(); !!}
    </div>
    <!--end::Card-->
@endsection
@section('js')
<script type="text/javascript">
    $('.select2').select2();
</script>
@endsection
