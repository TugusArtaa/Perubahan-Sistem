@extends('layouts.app')

@section('title', 'Test SweetAlert2')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Test SweetAlert2 Icons</h5>
                    <button class="btn btn-success me-2" onclick="testSuccess()">Test Success</button>
                    <button class="btn btn-danger me-2" onclick="testError()">Test Error</button>
                    <button class="btn btn-warning me-2" onclick="testWarning()">Test Warning</button>
                    <button class="btn btn-info me-2" onclick="testInfo()">Test Info</button>
                    <button class="btn btn-primary" onclick="testQuestion()">Test Question</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function testSuccess() {
    Swal.fire({
        title: 'Success!',
        text: 'This is a success message with fixed icon',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function testError() {
    Swal.fire({
        title: 'Error!',
        text: 'This is an error message',
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function testWarning() {
    Swal.fire({
        title: 'Warning!',
        text: 'This is a warning message',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function testInfo() {
    Swal.fire({
        title: 'Info!',
        text: 'This is an info message',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function testQuestion() {
    Swal.fire({
        title: 'Question?',
        text: 'This is a question message',
        icon: 'question',
        confirmButtonText: 'OK'
    });
}
</script>
@endpush
