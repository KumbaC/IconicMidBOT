@extends('admin.layouts.main')
@section('css')

@endsection
@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">Working Times Details
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ route('admin.working.edit', Crypt::encrypt($working->id)) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                            </g>
                        </svg>
                    </span>Working Time
                </a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p><b>Name:</b> {{ $working->user->name }}</p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Email:</b> {{ $working->user->email }}</p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Position: </b> {{$working->user->position->name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p><b>Entry date:</b> {{ date('d/m/y h:i a', strtotime($working->entry_date)) }}</p>
                    @if($working->centry == 0)
                    <span class="badge badge-danger">Entro tarde al trabajo</span>
                  @else
                      <span class="badge badge-success">Entro a su hora de trabajo.</span>
                  @endif
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Lunch Time: </b> {{ date('h:i a', strtotime($working->lunch_time)) }}</p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Back|Lunch: </b> {{ date('h:i a', strtotime($working->back_lunch)) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p><b>Firts Break:</b> @if($working->break == 1) Tomo el primer descanso a {{ date('h:i a', strtotime($working->break_time)) }}
                        @else
                         No tomo el descanso.
                        @endif</p>
                    </p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Back Break: </b> @if($working->break == 1) Regreso de su primer descanso a {{ date('h:i a', strtotime($working->back_break)) }}
                        @else
                        No tomo descanso
                        @endif</p>
                    </p>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p><b>Second Break:</b> @if($working->break_two == 1) Tomo el segundo descanso a {{ date('h:i a', strtotime($working->time_break_two)) }}
                        @else
                        No tomo el segundo descanso
                        @endif</p>
                    </p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Back Break: </b> @if($working->break_two == 1) Regreso al trabajo a {{ date('h:i a', strtotime($working->back_break_two)) }}
                        @else
                         No tomo el segundo descanso
                        @endif</p>
                    </p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Out| End time: </b>{{ date('d/m/y h:i a', strtotime($working->out)) }}</span></p>
                    </p>
                    @if($working->cout == 0)
                      <span class="badge badge-danger">Se fue antes de su hora de salida.</span>
                    @else
                        <span class="badge badge-success">Se fue a su hora de salida</span>
                    @endif
                </div>

            </div>


            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <p><b>Duration firts break:</b>
                        @php
                        $inicio = strtotime($working->break_time);
                        $fin = strtotime($working->back_break);

                        $duracion_segundos = $fin - $inicio;

                        $horas = floor($duracion_segundos / 3600);
                        $minutos = floor(($duracion_segundos % 3600) / 60);
                        $segundos = $duracion_segundos % 60;

                        echo "tardó $horas horas, $minutos minutos y $segundos segundos en el break.";

                        @endphp

                    </p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Duration second break:</b>
                        @php
                        $inicio = strtotime($working->time_break_two);
                        $fin = strtotime($working->back_break_two);

                        $duracion_segundos = $fin - $inicio;

                        $horas = floor($duracion_segundos / 3600);
                        $minutos = floor(($duracion_segundos % 3600) / 60);
                        $segundos = $duracion_segundos % 60;

                        echo "tardó $horas horas, $minutos minutos y $segundos segundos en el segundo break.";

                        @endphp

                    </p>
                </div>
                <div class="col-md-4  col-sm-12">
                    <p><b>Duration luch:</b>
                        @php
                        $inicio = strtotime($working->lunch_time);
                        $fin = strtotime($working->back_lunch);

                        $duracion_segundos = $fin - $inicio;

                        $horas = floor($duracion_segundos / 3600);
                        $minutos = floor(($duracion_segundos % 3600) / 60);
                        $segundos = $duracion_segundos % 60;

                        echo "tardó $horas horas, $minutos minutos y $segundos segundos en el lunch.";

                        @endphp

                    </p>
                </div>

            </div>

        </div>
    </div>
    <!--end::Card-->
@endsection
@section('js')
@endsection
