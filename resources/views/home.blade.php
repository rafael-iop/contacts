@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">API Info</div>

                <div class="card-body">
                    <ul>
                        <li>API docs: <a target="blank" href="https://documenter.getpostman.com/view/1044545/RW8FF6X9">https://documenter.getpostman.com/view/1044545/RW8FF6X9</a></li>
                        <li>API endpoint: <a href="{{ url('/api') }}">{{ url('/api') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
