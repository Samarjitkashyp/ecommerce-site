{{-- resources/views/admin/menus/locations.blade.php --}}
@extends('layouts.admin')

@section('title', 'Menu Locations')
@section('page-title', 'Menu Locations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Menu Locations Overview</h5>
                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Menu
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($locations as $key => $location)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ $location }}</h6>
                            </div>
                            <div class="card-body">
                                @if($menusByLocation[$key]->count() > 0)
                                    <ul class="list-group">
                                        @foreach($menusByLocation[$key] as $menu)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $menu->name }}</strong>
                                                    @if($menu->children->count() > 0)
                                                        <span class="badge bg-info ms-2">{{ $menu->children->count() }} children</span>
                                                    @endif
                                                    <br>
                                                    <small class="text-muted">Type: {{ $menu->type }}</small>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted text-center py-3">No menus in this location</p>
                                @endif
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.menus.create', ['location' => $key]) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-plus"></i> Add to {{ $location }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection