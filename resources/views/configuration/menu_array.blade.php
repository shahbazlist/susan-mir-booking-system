<?php

$menu = array (
  0 => 
  array (
    'name' => 'Dashboard',
    'icon' => 'fa fa-dashboard',
    'dropdown' => false,
    'route' => 'admin.dashboard',
    'dropdown_items' => 
    array (
    ),
  ),
  // 1 => 
  // array (
  //   'name' => 'Service',
  //   'icon' => 'fa fa-calendar-plus-o',
  //   'dropdown' => true,
  //   'route' => '',
  //   'dropdown_items' => 
  //   array (
  //     0 => 
  //     array (
  //       'name' => 'Service',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.service.index',
  //     ),
  //     1 => 
  //     array (
  //       'name' => 'Add Service Slot',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.service_slot.create',
  //     ),
  //     2 => 
  //     array (
  //       'name' => 'Manage Service',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.service_slot.index',
  //     ),
  //   ),
  // ),
  1 => 
  array (
    'name' => 'Service',
    'icon' => 'fa fa-calendar-plus-o',
    'dropdown' => true,
    'route' => '',
    'dropdown_items' => 
    array (
      0 => 
      array (
        'name' => 'Add Services',
        'icon' => 'fa fa-circle-o',
        'route' => 'admin.services.create',
      ),
      1 => 
      array (
        'name' => 'All Services',
        'icon' => 'fa fa-circle-o',
        'route' => 'admin.services.index',
      ),
      2 => 
      array (
        'name' => 'Availability',
        'icon' => 'fa fa-circle-o',
        'route' => 'admin.services.availability',
      ),
    ),
  ),

  2 => 
  array (
    'name' => 'Availability Slot',
    'icon' => 'fa fa-users',
    'dropdown' => true,
    'route' => '',
    'dropdown_items' => 
    array (
      0 => 
      array (
        'name' => 'Service Availability',
        'icon' => 'fa fa-circle-o',
        'route' => 'admin.slot.index',
      ),
    ),
  ),

  3 => 
  array (
    'name' => 'Booking',
    'icon' => 'fa fa-calendar-plus-o',
    'dropdown' => true,
    'route' => '',
    'dropdown_items' => 
    array (
      0 => 
      array (
        'name' => 'Bookings List',
        'icon' => 'fa fa-circle-o',
        'route' => 'admin.booking.index',
      ),
    ),
  ),

  
  // 3 => 
  // array (
  //   'name' => 'Users',
  //   'icon' => 'fa fa-users',
  //   'dropdown' => true,
  //   'route' => '',
  //   'dropdown_items' => 
  //   array (
  //     0 => 
  //     array (
  //       'name' => 'Add User',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.users.create',
  //     ),
  //     1 => 
  //     array (
  //       'name' => 'Manage Users',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.users.index',
  //     ),
  //     2 => 
  //     array (
  //       'name' => 'Manage User Roles',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.roles.index',
  //     ),
  //   ),
  // ),
  // 4 => 
  // array (
  //   'name' => 'Pages',
  //   'icon' => 'fa fa-file',
  //   'dropdown' => true,
  //   'route' => '',
  //   'dropdown_items' => 
  //   array (
  //     0 => 
  //     array (
  //       'name' => 'Add Page',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.pages.create',
  //     ),
  //     1 => 
  //     array (
  //       'name' => 'Manage Pages',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.pages.index',
  //     ),
  //   ),
  // ),
  // 5 => 
  // array (
  //   'name' => 'Settings',
  //   'icon' => 'fa fa-gear',
  //   'dropdown' => true,
  //   'route' => '',
  //   'dropdown_items' => 
  //   array (
  //     0 => 
  //     array (
  //       'name' => 'General Settings',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.settings.index',
  //     ),
  //     1 => 
  //     array (
  //       'name' => 'Edit Profile',
  //       'icon' => 'fa fa-circle-o',
  //       'route' => 'admin.settings.edit_profile',
  //     ),
  //   ),
  // ),
);









