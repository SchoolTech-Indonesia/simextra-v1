@extends('layouts.app') {{-- Assuming this is your main Stisla layout --}}

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Profile') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Permissions List') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('permission.create') }}" class="btn btn-primary">{{ __('Add Permission') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>{{ __('Permission Slug') }}</th>
                                        <th>{{ __('Permission Name') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission) {{-- Assuming $permissions is the correct variable --}}
                                    <tr>
                                        <td>{{ $permission->slug }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        {{-- Optional: Add pagination or other actions --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
