<?php  
<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>{{ __('Permission Slug') }}</th>
            <th>{{ __('Permission Name') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->slug }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    <!-- Example actions, adjust as needed -->
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
?>