@extends('dashboard.layout.dashboard')

@section('content')
    <form form-id="email-form-id" http-request route="{{ route('dashboard.send.email') }}"
        identifier="single-form-post-handler" success-toast feedback method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required feedback-id="email-feedback">
            <div id="email-feedback" class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3" required feedback-id="message-feedback"></textarea>
            <div id="message-feedback" class="invalid-feedback"></div>
        </div>
        <button submit-form-id="email-form-id" type="submit" class="btn btn-primary">Send Email</button>
    </form>
@endsection
