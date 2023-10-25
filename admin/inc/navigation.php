<style>
  .sidebar li.nav-item a {
    color: white; /* Text color */
    padding: 10px; 
  }
</style>
<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light-dark elevation-4 bg-primary text-white">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 2.5rem;height: 2.5rem;max-height: unset">
        <span class="brand-text font-weight-bold" style="font-size:14px;"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden" style="background-color:#2E4053">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 11px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=activities" class="nav-link nav-activities">
                        <i class="nav-icon fas fa-tasks" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Activities
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=announcement" class="nav-link nav-announcement">
                        <i class="nav-icon fas fa-bullhorn" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Announcement
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=registrations" class="nav-link nav-registrations">
                        <i class="nav-icon fas fa-address-card" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Registrations
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=attendance" class="nav-link nav-attendance">
                        <i class="nav-icon fas fa-user-friends" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Attendance
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=review" class="nav-link nav-review">
                        <i class="nav-icon fas fa-comment-alt" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                         Evaluations
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=contacts" class="nav-link nav-contacts">
                        <i class="nav-icon 	fas fa-users-cog" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                        Staff
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=videos" class="nav-link nav-videos">
                        <i class="nav-icon fas fa-video" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                        Videos
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=documents" class="nav-link nav-documents">
                        <i class="nav-icon fas fa-file-alt"style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                           Documents
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user/list">
                        <i class="nav-icon fas fa-user" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                           Users List
                        </p>
                      </a>
                    </li>
                    <li class="nav-header" style="font-size:20px;color:white">Report List</li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
                        <i class="nav-icon fas fa-layer-group"style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Report
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs" style="font-size:20px;"></i>
                        <p style="font-size:20px;">
                          Settings
                        </p>
                      </a>
                    </li>
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      page = page.split('/');
      page = page[0];
      if(s!='')
        page = page+'_'+s;

      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
     
    })
  </script>