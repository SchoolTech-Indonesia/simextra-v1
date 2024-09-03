<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="nav-item dropdown{% if 'index' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
  </li>
  <li class="menu-header">Main Menu</li>
  @role('superadmin')
  <li class="nav-item dropdown{% if 'layout' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>User</span></a>
    <ul class="dropdown-menu">
     
      <li{% if 'permissions-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('permissions.index') }}">Permission Management</a></li>
      <li{% if 'roles-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('roles.index') }}">Role Management</a></li>
      <li{% if 'users-management' in page %} class="active"{% endif %}><a class="nav-link" href="{{ route('users.index') }}">User Management</a></li>
      
    </ul>
  </li>
  @endrole
  <!-- Add more sections like above for other menus -->
</ul>
