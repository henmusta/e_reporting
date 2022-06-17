    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
        <div class="multinav-scroll" style="height: 100%;">
            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
              <li class="">
                <a href="{{ url('backend/dashboard') }}">
                  <i data-feather="monitor"></i>
                  <span>Dashboard</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>
              </li>
              <li class="">
                <a href="#">
                  <i data-feather="package"></i>
                  <span>Terumumkan</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>
              </li>
              <li class="">
                <a href="#">
                  <i data-feather="truck"></i>
                  <span>Proses Kontrak</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>
              </li>
              <li class="">
                <a href="#">
                  <i data-feather="pie-chart"></i>
                  <span>Pelaksanaan</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>
              </li>
              <li class="">
                <a href="#">
                  <i data-feather="trello"></i>
                  <span>Pekerjaan Selesai</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>
              </li>
              <li class="treeview">
                <a href="#">
                  <i data-feather="server"></i>
                  <span>Laporan</span>
                  <span class="pull-right-container">
                    {{-- <i class="fa fa-angle-right pull-right"></i> --}}
                  </span>
                </a>

              </li>
              {{-- <li class="treeview">
                <a href="#">
                  <i data-feather="grid"></i>
                  <span>Pengaturan</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="treeview">
                      <a href="#">
                          <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Apps
                          <span class="pull-right-container">
                              <i class="fa fa-angle-right pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="extra_calendar.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Calendar</a></li>
                          <li><a href="contact_app.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Contact List</a></li>
                          <li><a href="contact_app_chat.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Chat</a></li>
                          <li><a href="extra_taskboard.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Todo</a></li>
                          <li><a href="mailbox.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mailbox</a></li>
                      </ul>
                  </li>
                  <li class="treeview">
                      <a href="#">
                          <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Ecommerce
                          <span class="pull-right-container">
                              <i class="fa fa-angle-right pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="ecommerce_products.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Products</a></li>
                          <li><a href="ecommerce_cart.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Products Cart</a></li>
                          <li><a href="ecommerce_products_edit.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Products Edit</a></li>
                          <li><a href="ecommerce_details.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Product Details</a></li>
                          <li><a href="ecommerce_orders.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Product Orders</a></li>
                          <li><a href="ecommerce_checkout.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Products Checkout</a></li>
                      </ul>
                  </li>
                  <li class="treeview">
                      <a href="#">
                          <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Sample Pages
                          <span class="pull-right-container">
                              <i class="fa fa-angle-right pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                          <li><a href="invoice.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Invoice</a></li>
                          <li><a href="invoicelist.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Invoice List</a></li>
                          <li><a href="extra_app_ticket.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Support Ticket</a></li>
                          <li><a href="extra_profile.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User Profile</a></li>
                          <li><a href="contact_userlist_grid.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Userlist Grid</a></li>
                          <li><a href="contact_userlist.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Userlist</a></li>
                          <li><a href="sample_faq.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>FAQs</a></li>
                          <li><a href="sample_blank.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Blank</a></li>
                          <li><a href="sample_coming_soon.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Coming Soon</a></li>
                          <li><a href="sample_custom_scroll.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Custom Scrolls</a></li>
                          <li><a href="sample_gallery.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Gallery</a></li>
                          <li><a href="sample_lightbox.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Lightbox Popup</a></li>
                          <li><a href="sample_pricing.html"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Pricing</a></li>
                      </ul>
                  </li>
                </ul>
              </li> --}}
              <li class="treeview">
                <a href="#">
                  <i data-feather="lock"></i>
                  <span>Pengaturan</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Website</a></li>
                  <li><a href="#"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Admin</a></li>
                </ul>
              </li>

            </ul>


        </div>
      </div>
  </section>
