@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>All Users</h4>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr_No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>ROle_As</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach ($User as $Users)
                            <tr>
                                <td>{{$Users->user_id}}</td>
                                <td>{{$Users->name}}</td>
                                <td>{{$Users->email}}</td>
                                <td>{{$Users->role_as}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <nav aria-label="Page navigation" class="mt-4">
                @if ($User->hasPages())
                <ul class="pagination justify-content-end" role="navigation">
                    {{-- Previous Page Link --}}
                    @if ($User->onFirstPage())
                    <li class="page-item disabled prev" aria-disabled="true" aria-label="@lang('User.previous')">
                        <span class="page-link" aria-hidden="true"><i class="tf-icon bx bx-chevrons-left"></i></span>
                    </li>
                    @else
                    <li class="page-item prev">
                        <a class="page-link" href="{{ $User->previousPageUrl() }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener" rel="prev" aria-label="@lang('franchise.previous')"><i class="tf-icon bx bx-chevrons-left"></i></a>
                    </li>
                    @endif

                    <?php
                    $start = $User->currentPage() - 2; // show 3 pagination links before current
                    $end = $User->currentPage() + 2; // show 3 pagination links after current
                    if ($start < 1) {
                        $start = 1; // reset start to 1
                        $end += 1;
                    }
                    if ($end >= $User->lastPage()) $end = $User->lastPage(); // reset end to last page
                    ?>

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $User->url(1) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{1}}</a>
                        </li>
                        @if($User->currentPage() != 4)
                        {{-- "Three Dots" Separator --}}
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif
                    @endif
                        @for ($i = $start; $i <= $end; $i++) <li class="page-item {{ ($User->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $User->url($i) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{$i}}</a>
                        </li>
                        @endfor
                        @if($end < $User->lastPage())
                            @if($User->currentPage() + 3 != $User->lastPage())
                            {{-- "Three Dots" Separator --}}
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $User->url($User->lastPage()) }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener">{{$User->lastPage()}}</a>
                            </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($User->hasMorePages())
                            <li class="page-item next">
                                <a class="page-link" href="{{ $User->nextPageUrl() }}" rel="nofollow noreferrer noopener" rel="nofollow noreferrer noopener" rel="next" aria-label="@lang('franchise.next')"><i class="tf-icon bx bx-chevrons-right"></i></a>
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
@endsection