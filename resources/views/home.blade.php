@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-3">{{ __('Create Task') }}
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ url('store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="due_date">Due Date</label>
                                <input type="datetime-local" class="form-control" name="due_date" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" name="location" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Latitude</label>
                                <input type="text" class="form-control" name="latitude" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Longitude</label>
                                <input type="text" class="form-control" name="longitude" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="enable_weather">Enable Weather Information</label>
                                <input type="checkbox" name="enable_weather" id="enable_weather">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
