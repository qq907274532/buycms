<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">菜单</li>
        @include('sidebar-treeview', ['permissions' => $permissions, 'level' => 1])
        <!--
				<li class="treeview">
					<a href="#">
						<i class="fa fa-share"></i> <span>Multilevel</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
						<li>
							<a href="#">
								<i class="fa fa-circle-o"></i> Level One
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
								<li>
									<a href="#">
										<i class="fa fa-circle-o"></i> Level Two
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a>
				</li>
			-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>