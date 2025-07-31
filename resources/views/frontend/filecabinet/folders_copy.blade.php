@extends('frontend.master')
@section('title', 'File Cabinet')
@section('content')
<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="web-card h-100 mb-3">
                    <div class="flex justify-center coming-soon">
                        <div class="text-center  no-records-body">
                            <img src="{{asset('images/nodata.png')}}"
                                class=" h-auto">
                            <h2 class="d-flex align-items-center justify-content-center gap-2"><span class="material-symbols-outlined">campaign</span>Coming Soon</h2>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

@endsection()