
<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="nav-item dropdown{% if 'index' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
  </li>
  <li class="menu-header">Master Data</li>
  <li class="nav-item dropdown{% if 'layout' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>User</span></a>
    <ul class="dropdown-menu">
      <li class="active"{% endif %}><a class="nav-link" href="{{ route('permissions.index') }}">Permission Management</a></li>
    </ul>
  </li>
  <!-- Add more sections like above for other menus -->
</ul>
