@extends('layouts.admin')

@section('title', 'Tài khoản')
@section('page_title', 'Quản lý tài khoản')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    class="form-control filter-control--keyword-user" placeholder="Họ tên, tên đăng nhập, email..."
                    aria-label="Tìm tài khoản">

                <select name="role" class="form-select filter-control--role" aria-label="Lọc theo vai trò">
                    <option value="">Mọi vai trò</option>
                    <option value="user" @selected(request('role')=='user' )>User</option>
                    <option value="admin" @selected(request('role')=='admin' )>Admin</option>
                </select>

                <select name="status" class="form-select filter-control--status" aria-label="Lọc theo trạng thái">
                    <option value="">Mọi trạng thái</option>
                    <option value="active" @selected(request('status')=='active' )>Active</option>
                    <option value="inactive" @selected(request('status')=='inactive' )>Inactive</option>
                </select>

                <button type="submit" class="btn btn-toy"><i class="bi bi-search"></i> Tìm</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
            </form>

            <a href="{{ route('admin.users.create') }}" class="btn btn-toy">
                <i class="bi bi-plus-lg"></i> Thêm tài khoản
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="table-column-id">#</th>
                        <th class="table-column-avatar">Ảnh</th>
                        <th>Họ tên</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th class="text-end table-column-user-actions">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>
                            <img src="{{ $u->avatar ? asset('storage/'.$u->avatar) : 'https://placehold.co/40x40?text=U' }}"
                                class="avatar-sm" alt="">
                        </td>
                        <td class="fw-semibold">{{ $u->full_name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if($u->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                            @else
                            <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            @if($u->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-dark">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle', $u) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                    title="{{ $u->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}"
                                    aria-label="{{ $u->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }} tài khoản {{ $u->username }}">
                                    <i class="bi {{ $u->is_active ? 'bi-lock' : 'bi-unlock' }}"></i>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary"
                                aria-label="Sửa tài khoản {{ $u->username }}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xóa tài khoản «{{ $u->username }}»?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    aria-label="Xóa tài khoản {{ $u->username }}"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Không có tài khoản nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection