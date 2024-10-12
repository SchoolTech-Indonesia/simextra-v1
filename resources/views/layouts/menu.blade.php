<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="nav-item{% if 'index' in page %} active{% endif %}">
    <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
  </li>

  <li class="menu-header">Main Menu</li>
  <li class="nav-item dropdown{% if 'layout' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>User</span></a>
    <ul class="dropdown-menu">
      <li{% if 'permissions-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('permissions.index') }}">Permission Management</a></li>
      <li{% if 'roles-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('roles.index') }}">Role Management</a></li>
      <li{% if 'users-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('users.index') }}">User Management</a></li>
    </ul>
  </li>
  <li class="nav-item{% if 'schools-management' in page %} active{% endif %}">
    <a href="{{ route('schools.index') }}" class="nav-link"><i class="fas fa-building"></i> <span>School Management</span></a>
  </li>
  <li class="nav-item{% if 'majors-management' in page %} active{% endif %}">
    <a href="{{ route('majors.index') }}" class="nav-link"><i class="fas fa-building"></i> <span>Major Management</span></a>
  </li>
  <li class="nav-item{% if 'class-management' in page %} active{% endif %}">
    <a href="{{ route('classroom.index') }}" class="nav-link"><i class="fas fa-building"></i> <span>Class Management</span></a>
  </li>
  <li class="nav-item{% if 'extras-management' in page %} active{% endif %}">
    <a href="{{ route('extras.index') }}" class="nav-link"><i class="fas fa-building"></i> <span>Extra Management</span></a>
  </li>
</ul>
