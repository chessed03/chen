@extends('template.app') 
@section('content')

<div class="row">

    <div class="col-12">

        <div class="page-title-box">

            <div class="page-title-right">

                <ol class="breadcrumb m-0">

                    <li class="breadcrumb-item">

                        <a href="javascript: void(0);">{{ ENV('APP_NAME') }}</a>

                    </li>

                    <li class="breadcrumb-item active">{{ $module }}</li>

                </ol>

            </div>

            <h4 class="page-title">{{ $module }}</h4>

        </div>

    </div>

    <div class="col-12">
        @livewire('subjects.subjects', [
            'module' => $module
        ])
    </div>

</div>

@endsection