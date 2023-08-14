@extends('admin.layouts.main')
@section('css')

@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">Add Working Time
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.working.index') }}" class="btn btn-primary font-weight-bolder">
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
        {!! Form::open(['route' => ['admin.working.store'], 'method' => 'POST', 'id' => 'add_working']) !!}
			{{ csrf_field() }}
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label class="col-form-label" for="categories">Users | Empleados <span class="asterisk-required">*</span></label>
                        <select class="form-control select2" id="users" name="user_id">
                                @foreach ($user as $users)
                                <option value="{{$users->id}}">
                                    {{$users->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-4">
                        <label class="col-form-label">Entry date | Hora de entrada <span class="asterisk-required">*</span></label>
                        {!! Form::datetimeLocal('entry_date', null, array('class'=>'form-control', 'id'=>'entry_date')) !!}
                    </div>
                    <div class="form-group col-4">
                        <label class="col-form-label">Lunch time | Hora de almuerzo <span class="asterisk-required">*</span></label>
                        {!! Form::time('lunch_time', '', array('class'=>'form-control', 'id'=>'lunch_time')) !!}
                    </div>
                    <div class="form-group col-4">
                        <label class="col-form-label">Back | Regreso del almuerzo<span class="asterisk-required">*</span></label>
                        {!! Form::time('back_lunch', '', array('class'=>'form-control', 'id'=>'back_lunch')) !!}
                    </div>
                </div>




                <div class="form-group col-6">
                    {{ Form::radio('centry', 1, array('class'=>'form-control', 'id'=>'rad')) }}
                    <label class="col-form-label">I enter early or on time</label>

                    {{ Form::radio('centry', 0, array('class'=>'form-control', 'id'=>'rad2')) }}
                    <label class="col-form-label">I'm late for work</label>
                </div>
                <hr>



                <div class="form-group col-6">
                    {{ Form::radio('break', 1, array('class'=>'form-control', 'id'=>'radio')) }}
                    <label class="col-form-label">First break</label>

                    {{ Form::radio('break', 0, array('class'=>'form-control', 'id'=>'radio2')) }}
                    <label class="col-form-label">Without a break </label>
                </div>
                <hr>
                <div class="form-group col-6">
                    {{ Form::radio('break_two', 1, array('class'=>'form-control', 'id'=>'radio3')) }}
                    <label class="col-form-label">Second break</label>

                    {{ Form::radio('break_two', 0, array('class'=>'form-control', 'id'=>'radio4')) }}
                    <label class="col-form-label">Without a break </label>
                </div>



                <div class="row break" style="display: none;">

                    <div class="form-group col-6 break">
                        <label class="col-form-label">Break Time<span class="asterisk-required">*</span></label>
                        {!! Form::time('break_time', '', array('class'=>'form-control', 'id'=>'break_time')) !!}
                    </div>

                    <div class="form-group col-6 break">
                        <label class="col-form-label">Back | Return of the first break<span class="asterisk-required">*</span></label>
                        {!! Form::time('back_break', '', array('class'=>'form-control', 'id'=>'back_break')) !!}
                    </div>


                </div>
                <div class="row break2" style="display: none;">

                    <div class="form-group col-6">
                        <label class="col-form-label">Time break two<span class="asterisk-required">*</span></label>
                        {!! Form::time('time_break_two', '', array('class'=>'form-control', 'id'=>'time_break_two')) !!}
                    </div>


                    <div class="form-group col-6">
                        <label class="col-form-label">Back | Return of the second break<span class="asterisk-required">*</span></label>
                        {!! Form::time('back_break_two', '', array('class'=>'form-control', 'id'=>'back_break_two')) !!}
                    </div>


                </div>



                <div class="row">
                    <div class="form-group col-12">
                        <label class="col-form-label">Out| Hora de salida <span class="asterisk-required">*</span></label>
                        {!! Form::datetimeLocal('out', '', array('class'=>'form-control', 'id'=>'out')) !!}
                    </div>
                </div>
                <hr>
                <div class="form-group col-6">
                    {{ Form::radio('cout', 1, array('class'=>'form-control', 'id'=>'rad3')) }}
                    <label class="col-form-label">Left on time or after</label>

                    {{ Form::radio('cout', 0, array('class'=>'form-control', 'id'=>'rad4')) }}
                    <label class="col-form-label">Left early</label>
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
    $('.select2').select2({
        width: '100%'
    });


$('input[name="break"]').change(function() {


  if ($(this).val() == 1) {
    // Mostrar el input oculto
    $('.break').show();
  } else {
    // Ocultar el input
    $('.break').hide();
  }
});

$('input[name="break_two"]').change(function() {


  if ($(this).val() == 1) {
    // Mostrar el input oculto
    $('.break2').show();
  } else {
    // Ocultar el input
    $('.break2').hide();
  }
});



</script>
@endsection
