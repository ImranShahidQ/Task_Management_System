@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center mb-3">{{ __('Edit Task') }}
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('update', ['task' => $task->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Use PUT method for update --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" rows="3" class="form-control" required>{{ old('description', $task->description) }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="due_date">Due Date</label>
                                <input type="datetime-local" class="form-control" name="due_date" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i:s')) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location', $task->location) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Latitude</label>
                                <input type="text" class="form-control" name="latitude" value="{{ old('location', $task->latitude) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="location">Longitude</label>
                                <input type="text" class="form-control" name="longitude" value="{{ old('location', $task->longitude) }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="enable_weather">Enable Weather Information</label>
                                <input type="checkbox" name="enable_weather" id="enable_weather" {{ old('enable_weather', $task->weather_info) ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
