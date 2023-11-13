@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>All Tasks</h4>
                        <!-- Add Task Button -->
                        <a href="{{ route('create') }}" class="btn btn-success">Add Task</a>
                    </div>
                                @if (count($tasks) > 0)
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table" style="border: 1px solid;">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Due_Date</th>
                                                    <th>Location</th>
                                                    <th>Temperature</th>
                                                    <th>Weather Condition</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @foreach ($tasks as $task)
                                                    @if (!$task->trashed()) {{-- Check if the task is not soft-deleted --}}
                                                        <tr>
                                                            <td>{{$task->title}}</td>
                                                            <td>{{$task->description}}</td>
                                                            <td>{{$task->due_date}}</td>
                                                            <td>{{$task->location}}</td>
                                                            <td>{{$task->temperature}}°C</td>
                                                            <td>{{$task->weather_condition}}</td>
                                                            <td>
                                                                <a href="{{ route('edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                                <form action="{{ route('destroy', $task->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @else
                                    <p>No tasks found.</p>
                                @endif
                                <nav aria-label="Page navigation" class="mt-4">
                                    @if ($tasks->hasPages())
                                    <ul class="pagination justify-content-end" role="navigation">
                                        {{-- Previous Page Link --}}
                                        @if ($tasks->onFirstPage())
                                        <li class="page-item disabled prev" aria-disabled="true" aria-label="@lang('tasks.previous')">
                                            <span class="page-link" aria-hidden="true"><i class="tf-icon bx bx-chevrons-left"></i></span>
                                        </li>
                                        @else
                                        <li class="page-item prev">
                                            <a class="page-link" href="{{ $tasks->previousPageUrl() }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener" rel="prev" aria-label="@lang('franchise.previous')"><i class="tf-icon bx bx-chevrons-left"></i></a>
                                        </li>
                                        @endif

                                        <?php
                                        $start = $tasks->currentPage() - 2; // show 3 pagination links before current
                                        $end = $tasks->currentPage() + 2; // show 3 pagination links after current
                                        if ($start < 1) {
                                            $start = 1; // reset start to 1
                                            $end += 1;
                                        }
                                        if ($end >= $tasks->lastPage()) $end = $tasks->lastPage(); // reset end to last page
                                        ?>

                                        @if($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $tasks->url(1) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{1}}</a>
                                            </li>
                                            @if($tasks->currentPage() != 4)
                                            {{-- "Three Dots" Separator --}}
                                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                            @endif
                                        @endif
                                            @for ($i = $start; $i <= $end; $i++) <li class="page-item {{ ($tasks->currentPage() == $i) ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $tasks->url($i) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{$i}}</a>
                                            </li>
                                            @endfor
                                            @if($end < $tasks->lastPage())
                                                @if($tasks->currentPage() + 3 != $tasks->lastPage())
                                                {{-- "Three Dots" Separator --}}
                                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                                @endif
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $tasks->url($tasks->lastPage()) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{$tasks->lastPage()}}</a>
                                                </li>
                                                @endif

                                                {{-- Next Page Link --}}
                                                @if ($tasks->hasMorePages())
                                                <li class="page-item next">
                                                    <a class="page-link" href="{{ $tasks->nextPageUrl() }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener" rel="next" aria-label="@lang('franchise.next')"><i class="tf-icon bx bx-chevrons-right"></i></a>
                                                </li>
                                                @else
                                                <li class="page-item disabled next" aria-disabled="true" aria-label="@lang('franchise.next')">
                                                    <span class="page-link" aria-hidden="true"><i class="tf-icon bx bx-chevrons-right"></i></span>
                                                </li>
                                            @endif
                                    </ul>
                                    @endif
                                </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
