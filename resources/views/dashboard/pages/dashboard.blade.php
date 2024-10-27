@extends('dashboard.layout.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Dashboard</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($students as $student)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">NAME: {{ $student->name }}</h5>
                            <p class="card-text">UUID: {{ $student->uuid }}</p>
                            <p class="card-text">PHONE: {{ $student->phone }}</p>
                            <p class="card-text">PASSWORD: password</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <button class="btn btn-primary copy-all-btn">
                    Copy All Students Info
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const copyAllBtn = document.querySelector('.copy-all-btn');
        copyAllBtn.addEventListener('click', function() {
            const students = @json($students);
            let clipboardText = '';
            students.forEach((student, index) => {
                clipboardText += `NAME: ${student.name}\nUUID: ${student.uuid}\nPHONE: ${student.phone}\nPASSWORD: password`;
                if (index < students.length - 1) {
                    clipboardText += '\n\n'; // Add two newlines between students
                }
            });
            navigator.clipboard.writeText(clipboardText).then(() => {
                alert('All students info copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        });
    });
</script>
@endpush

