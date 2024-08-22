<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="nav-item dropdown{% if 'index' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
  </li>
  <li class="menu-header">Main Menu</li>
  <li class="nav-item dropdown{% if 'layout' in page %} active{% endif %}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
    <ul class="dropdown-menu">
      <li{% if 'layout-default' in page %} class="active"{% endif %}><a class="nav-link" href="layout-default.html">Default Layout</a></li>
      <li{% if 'layout-transparent' in page %} class="active"{% endif %}><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
      <li{% if 'layout-top' in page %} class="active"{% endif %}><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
    </ul>
  </li>
  <!-- Add more sections like above for other menus -->
</ul>
