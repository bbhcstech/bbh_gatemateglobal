  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
           
            <a href="{{ route('home') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg width="200" height="80" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                  <!-- QR-style blocks -->
                  <rect x="5" y="5" width="20" height="20" fill="#000"/>
                  <rect x="35" y="5" width="20" height="20" fill="#000"/>
                  <rect x="5" y="35" width="20" height="20" fill="#000"/>
                  <rect x="20" y="20" width="10" height="10" fill="#000"/>
                  <rect x="35" y="35" width="20" height="20" fill="#000"/>
                  <rect x="65" y="5" width="20" height="20" fill="#000"/>
                  <rect x="65" y="35" width="20" height="20" fill="#000"/>

                  <!-- Brand text -->
                  <text x="100" y="50" font-size="36" fill="#7c1f8c" font-family="Arial, sans-serif" font-weight="bold">
                   GateMate
                  </text>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2 d-none">GateMate</span>
            </a>


            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
              
              <!-- Dashboards -->


        {{-- Dashboard --}}
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div class="text-truncate" data-i18n="Dashboard">&nbsp;Dashboard</div>
            </a>
        </li>
        
        
             {{-- Users (Admin only) --}}
        @if(auth()->check() && auth()->user()->role_name === 'admin')
            <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div class="text-truncate" data-i18n="Users">&nbsp;Users</div>
                </a>
            </li>
        @endif
        
        <!--@if(auth()->check() && auth()->user()->role === 'admin')-->
        <!--    <li class="menu-item {{ request()->routeIs('parking.index') ? 'active' : '' }}">-->
        <!--        <a href="{{ route('parking.index') }}" class="menu-link">-->
        <!--            <i class="fas fa-parking"></i>-->
        <!--            <div class="text-truncate" data-i18n="Parking">&nbsp;Parking Management</div>-->
        <!--        </a>-->
        <!--    </li>-->
        <!--@endif-->

        @if(auth()->check() && auth()->user()->role_name === 'admin')
         <li class="menu-item {{ request()->routeIs('towers.create') ? 'active' : '' }}">
            <a href="{{ route('towers.create') }}" class="menu-link">
                <i class="fas fa-building"></i>
                <div class="text-truncate" data-i18n="Dashboard">&nbsp;Tower / Floor / Flat</div>
            </a>
        </li>

         @endif
              @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident']))

            <!-- Recident -->
             <li class="menu-item has-sub {{ request()->routeIs(
                    'residents.*',
                    'family-members.*',
                    'pets.*','complaint.*','vehicles.*'
                ) ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="fas fa-users"></i>
                    <div class="text-truncate">&nbsp;Residents</div>
                </a>
            
                <ul class="menu-sub">
                    @if(auth()->check() && auth()->user()->role_name === 'admin')
                    <li class="menu-item">
                        <a href="{{ route('residents.index') }}" class="menu-link">
                            <i class="fas fa-user-friends"></i>
                            <div class="text-truncate">&nbsp;All Residents</div>
                        </a>
                    </li>
                @endif
                    <li class="menu-item">
                        <a href="{{ route('family-members.index') }}" class="menu-link">
                            <i class="fas fa-home"></i>
                            <div class="text-truncate">&nbsp;Family Members</div>
                        </a>
                    </li>
                    
                    <li class="menu-item">
                    <a href="{{ route('pets.index') }}" class="menu-link">
                        <i class="fas fa-paw"></i>
                        <div>Pets</div>
                    </a>
                </li>
                
                <li class="menu-item">
                    <a href="{{ route('complaints.index') }}" class="menu-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="text-truncate" data-i18n="Dashboard">&nbsp;Raise Complaint</div>
                    </a>
                </li>
                
                 
                <li class="menu-item ">
                    <a href="{{ route('vehicles.index') }}" class="menu-link">
                        <i class="fas fa-taxi"></i>

                        <div class="text-truncate" data-i18n="Domestic Help">&nbsp; Vehicles</div>
                    </a>
                  </li>             
  
                </ul>
            </li>

               @endif
               
        
       @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident','security']))
               <li class="menu-item 
                {{ request()->routeIs(
                    'visitors.*',
                    'visitor-preapproval.*',
                    'visitor-logs.*'
                ) ? 'open' : '' }}">


    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fas fa-shield-alt"></i>
        <div class="text-truncate">&nbsp;Pre-Approve</div>
    </a>

    <ul class="menu-sub">

        {{-- Visitors --}}
        <!--<li class="menu-item {{ request()->routeIs('visitors.*') ? 'active' : '' }}">-->
        <!--    <a href="{{ route('visitors.index') }}" class="menu-link">-->
        <!--        <i class="fas fa-user-friends me-2"></i>-->
        <!--        <div class="text-truncate">Visitors</div>-->
        <!--    </a>-->
        <!--</li>-->


        {{-- Visitor Pre-Approval --}}
        <li class="menu-item {{ request()->routeIs('visitor-preapproval.*') ? 'active' : '' }}">
            <a href="{{ route('visitor-preapproval.index') }}" class="menu-link">
                <i class="fas fa-check-circle me-2"></i>
                <div class="text-truncate">Guest Pre-Approval</div>
            </a>
        </li>
@endif

  @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['security']))
        {{-- Visitor Entry / Exit --}}
        <li class="menu-item {{ request()->routeIs('visitor-logs.*') ? 'active' : '' }}">
            <a href="{{ route('visitor-logs.index') }}" class="menu-link">
                <i class="fas fa-door-open me-2"></i>
                <div class="text-truncate">Guest Entry / Exit</div>
            </a>
        </li>
        
        

    </ul>
    @endif
</li>

 @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident','security']))
             
      
        
        
        <li class="menu-item {{ request()->routeIs('domestic-helps.*','help.attendance.*','help.payments.*','help-ratings.*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fas fa-broom"></i>
        <div class="text-truncate" data-i18n="Domestic Help">&nbsp; Visiting Help</div>
    </a>

             
    <ul class="menu-sub">

        <li class="menu-item {{ request()->routeIs('domestic-helps.*') ? 'active' : '' }}">
            <a href="{{ route('domestic-helps.index') }}" class="menu-link">
               ЁЯСе Domestic Helper
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('help.attendance.*') ? 'active' : '' }}">
            <a href="{{ route('help.attendance.index') }}" class="menu-link">
               ЁЯУЕ Attendance
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('help.payments.*') ? 'active' : '' }}">
            <a href="{{ route('help.payments.index') }}" class="menu-link">
               ЁЯТ░ Payments
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('help.ratings.*') ? 'active' : '' }}">
            <a href="{{ route('help-ratings.index') }}" class="menu-link">
                тнР Ratings
            </a>
        </li>

    </ul>
</li>



        <li class="menu-item {{ request()->routeIs('cab.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fas fa-taxi"></i>
                <div class="text-truncate" data-i18n="Domestic Help">&nbsp; Cab Management</div>
            </a>
            
             <ul class="menu-sub">
           @if(auth()->check() && in_array(auth()->user()->role, ['resident']))
                <li class="menu-item {{ request()->routeIs('cab.*') ? 'active' : '' }}">
                    <a href="{{ route('cab.create') }}" class="menu-link">
                       Pre-Approve Cab Requests
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('cab.*') ? 'active' : '' }}">
                    <a href="{{ route('cab.index') }}" class="menu-link">
                       My Pre-Approve Cab
                    </a>
                </li>
           @endif     
         
            @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin','security']))
                <li class="menu-item {{ request()->routeIs('cab.*') ? 'active' : '' }}">
                    <a href="{{ route('cab.index') }}" class="menu-link">
                       Pre-Approve Cab
                    </a>
                </li>
                @endif 
                
                
                
                 @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['security']))
                <li class="menu-item {{ request()->routeIs('cab.*') ? 'active' : '' }}">
                    <a href="{{ route('cab.entry.list') }}" class="menu-link">
                        🚕 Cab Entry / Exit
                    </a>
                </li>
           
            
           
            @endif
            
            
            

             </ul>

             
   
</li>

<li class="menu-item {{ request()->routeIs('delivery.*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="fas fa-box"></i>
        <div class="text-truncate">&nbsp; Delivery Management</div>
    </a>

    <ul class="menu-sub">

       
          @if(auth()->check() && auth()->user()->role_name === 'resident')
            <li class="menu-item {{ request()->routeIs('delivery.create') ? 'active' : '' }}">
                <a href="{{ route('delivery.create') }}" class="menu-link">
                    Pre-Approve Delivery
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('delivery.index') ? 'active' : '' }}">
                <a href="{{ route('delivery.index') }}" class="menu-link">
                    My Pre-Approved Deliveries
                </a>
            </li>
        @endif

        {{-- ADMIN & SECURITY --}}
      
        @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin','security']))
            <li class="menu-item {{ request()->routeIs('delivery.index') ? 'active' : '' }}">
                <a href="{{ route('delivery.index') }}" class="menu-link">
                    Pre-Approved Deliveries
                </a>
            </li>
        @endif

        {{-- SECURITY ONLY --}}
      
       @if(auth()->check() && auth()->user()->role_name === 'security')
            <li class="menu-item {{ request()->routeIs('delivery.entry.*') ? 'active' : '' }}">
                <a href="{{ route('delivery.entry.index') }}" class="menu-link">
                    🚚 Delivery Entry / Exit
                </a>
            </li>
        @endif

    </ul>
</li>



  @endif
              
                @if(auth()->check() && in_array(strtolower(optional(auth()->user()->roleMaster)->role_name), ['admin', 'resident','security']))
            <!--<li class="menu-item {{ request()->routeIs('vendor-visits.*') ? 'open' : '' }}">-->
            <!--    <a href="javascript:void(0);" class="menu-link menu-toggle">-->
            <!--        <i class="fas fa-truck"></i>-->
            <!--        <div class="text-truncate">&nbsp;Vendor Visits</div>-->
            <!--    </a>-->
            
            <!--    <ul class="menu-sub">-->
            <!--        <li class="menu-item {{ request()->routeIs('vendor-visits.index') ? 'active' : '' }}">-->
            <!--            <a href="{{ route('vendor-visits.index') }}" class="menu-link">-->
            <!--                <i class="fas fa-list me-2"></i>-->
            <!--                <div class="text-truncate">All Visits</div>-->
            <!--            </a>-->
            <!--        </li>-->
            
            <!--        <li class="menu-item {{ request()->routeIs('vendor-visits.create') ? 'active' : '' }}">-->
            <!--            <a href="{{ route('vendor-visits.create') }}" class="menu-link">-->
            <!--                <i class="fas fa-plus me-2"></i>-->
            <!--                <div class="text-truncate">Add Visit</div>-->
            <!--            </a>-->
            <!--        </li>-->
            <!--    </ul>-->
            <!--</li>-->
            @endif

  




  
    
     @if(auth()->check() && auth()->user()->role_name === 'admin')
               <li class="menu-item {{ request()->routeIs('patrols.*') ? 'active' : '' }}">


                <a href="{{ route('patrols.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Without menu">
                     <i class="fas fa-walking me-2"></i>&nbsp; Patrols
                    </div>
                  </a>

      
                </li>

               <li class="menu-item {{ request()->routeIs('security-guards.*') ? 'active' : '' }}">


                <a href="{{ route('security-guards.index') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Without menu">
                      <i class="fas fa-user-shield me-2"></i>&nbsp; Security Guards
                    </div>
                  </a>

      
                </li>
                
              </ul>
            </li>

           
             <li class="menu-item">
                  <a href="{{ route('amenities.index') }}" class="menu-link">
                     <i class="fas fa-swimming-pool"></i>&nbsp;
                      <div class="text-truncate" data-i18n="Dashboard">&nbsp;Amenities</div>
                  </a>
              </li>
@endif
            <!-- Apps & Pages -->
            {{-- <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Apps &amp; Pages</span>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-email.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-envelope"></i>
                <div class="text-truncate" data-i18n="Email">Email</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-chat.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div class="text-truncate" data-i18n="Chat">Chat</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-calendar.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div class="text-truncate" data-i18n="Calendar">Calendar</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-kanban.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid"></i>
                <div class="text-truncate" data-i18n="Kanban">Kanban</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <!-- Pages -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Account Settings</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-account-settings-account.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Account</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Notifications</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-connections.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Connections">Connections</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div class="text-truncate" data-i18n="Authentications">Authentications</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="auth-login-basic.html" class="menu-link" target="_blank">
                    <div class="text-truncate" data-i18n="Basic">Login</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-register-basic.html" class="menu-link" target="_blank">
                    <div class="text-truncate" data-i18n="Basic">Register</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                    <div class="text-truncate" data-i18n="Basic">Forgot Password</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div class="text-truncate" data-i18n="Misc">Misc</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-misc-error.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Error">Error</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-misc-under-maintenance.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Under Maintenance">Under Maintenance</div>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
            <!-- Cards -->
            <li class="menu-item">
              <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div class="text-truncate" data-i18n="Basic">Cards</div>
              </a>
            </li>
            <!-- User interface -->
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div class="text-truncate" data-i18n="User interface">User interface</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="ui-accordion.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Accordion">Accordion</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-alerts.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Alerts">Alerts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-badges.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Badges">Badges</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-buttons.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Buttons">Buttons</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-carousel.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Carousel">Carousel</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-collapse.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Collapse">Collapse</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-dropdowns.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Dropdowns">Dropdowns</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-footer.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Footer">Footer</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-list-groups.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Groups">List groups</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-modals.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Modals">Modals</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-navbar.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Navbar">Navbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-offcanvas.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Offcanvas">Offcanvas</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-pagination-breadcrumbs.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Pagination & Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-progress.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Progress">Progress</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-spinners.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Spinners">Spinners</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tabs-pills.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Tabs & Pills">Tabs &amp; Pills</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-toasts.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Toasts">Toasts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tooltips-popovers.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Tooltips & Popovers">Tooltips &amp; Popovers</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-typography.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Typography">Typography</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Extended components -->
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div class="text-truncate" data-i18n="Extended UI">Extended UI</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Perfect Scrollbar">Perfect Scrollbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="extended-ui-text-divider.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Text Divider">Text Divider</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-item">
              <a href="icons-boxicons.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div class="text-truncate" data-i18n="Boxicons">Boxicons</div>
              </a>
            </li>

            <!-- Forms & Tables -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span></li>
            <!-- Forms -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div class="text-truncate" data-i18n="Form Elements">Form Elements</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="forms-basic-inputs.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Basic Inputs">Basic Inputs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="forms-input-groups.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Input groups">Input groups</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div class="text-truncate" data-i18n="Form Layouts">Form Layouts</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="form-layouts-vertical.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Vertical Form">Vertical Form</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="form-layouts-horizontal.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Horizontal Form">Horizontal Form</div>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Form Validation -->
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/form-validation.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div class="text-truncate" data-i18n="Form Validation">Form Validation</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <!-- Tables -->
            <li class="menu-item">
              <a href="tables-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div class="text-truncate" data-i18n="Tables">Tables</div>
              </a>
            </li>
            <!-- Data Tables -->
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/tables-datatables-basic.html"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid"></i>
                <div class="text-truncate" data-i18n="Datatables">Datatables</div>
                <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div>
              </a>
            </li>
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div class="text-truncate" data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div class="text-truncate" data-i18n="Documentation">Documentation</div>
              </a>
            </li> --}}
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base bx bx-menu icon-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center me-auto">
                <div class="nav-item d-flex align-items-center">
                  <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                    placeholder="Searchadmin."
                    aria-label="Searchadmin." />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- Place this tag where you want the button to render. -->
                {{-- <li class="nav-item lh-1 me-4">
                  <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li> --}}

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="admin/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="admin/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          @php
                              use App\Models\User;
                              $user = auth()->user();
                          @endphp

                          <div class="flex-grow-1">
                              <h6 class="mb-0">{{ $user->name }}</h6>
                              <small class="text-body-secondary">{{ ucfirst($user->role) }}</small>
                          </div>

                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                      </a>
                    </li> --}}
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i
                          ><span class="flex-grow-1 align-middle">Billing Plan</span>
                          <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                        </span>
                      </a>
                    </li> --}}
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>

                      <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                               <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                            </x-dropdown-link>
                        </form>
                      
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->