
@extends('layouts.default')

@push('styles')
<style>
    .container{
        width: 980px;
        margin-right: auto;
        margin-left: auto;
    }
    .newsfeed-placeholder {
        border: 2px dashed rgba(27,31,35,0.3);
        border-radius: 5px;
    }
    .p-5 {
        padding: 32px !important;
    }
    .mb-4 {
        margin-bottom: 24px !important;
    }
</style>
@endpush

@push('scripts')

<script type="text/javascript">


</script>

@endpush

@section('title')
Event
@endsection

@section('content')

<div class="container page-content">
    <div class="row">
        <div class="col-md-8">
            <ul class="nav nav-tabs mb-4">
                <li class="active"><a data-toggle="tab" href="#about">About</a></li>
                <li><a data-toggle="tab" href="#portfolio">Portfolio</a></li>
            </ul>

            <div class="tab-content">
                <div id="about" class="tab-pane fade in active">
                    <div class="newsfeed-placeholder p-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <img src="" >
                                </div>
                            </div>
                            <div class="col-md-6">
a
                            </div>
                        </div>
                    </div>
                </div>
                <div id="portfolio" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
                <h1>das</h1>
        </div>

    </div>
</div>

@endsection