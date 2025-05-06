<div class="left-side-bar">
	<div class="brand-logo">
		<a href="<?= route_to('home') ?>">
			<img src="/resource/vendors/images/Logo-Innotex-Blue.png" alt="" class="dark-logo" />
			<img
				src="/resource/vendors/images/Logo-Innotex-Blue.png"
				alt=""
				class="light-logo" />
		</a>
		<div class="close-sidebar" data-toggle="left-sidebar-close">
			<i class="ion-close-round"></i>
		</div>
	</div>
	<div class="menu-block customscroll">
		<div class="sidebar-menu">
			<ul id="accordion-menu">
				<li>
					<a
						href="<?= route_to('team') ?>"
						class="dropdown-toggle no-arrow">
						<span class="micon bi bi-layout-text-window-reverse"></span>
						<span class="mtext">team</span>
					</a>
				</li>
				<li>
					<a
						href="<?= route_to('event') ?>"
						class="dropdown-toggle no-arrow">
						<span class="micon bi bi-layout-text-window-reverse"></span>
						<span class="mtext">event</span>
					</a>
				</li>
				<li>
					<a
						href="<?= route_to('event.match') ?>"
						class="dropdown-toggle no-arrow">
						<span class="micon bi bi-layout-text-window-reverse"></span>
						<span class="mtext">match</span>
					</a>
				</li>
				<li>
					<a
						href="<?= route_to('report') ?>"
						class="dropdown-toggle no-arrow">
						<span class="micon bi bi-layout-text-window-reverse"></span>
						<span class="mtext">report</span>
					</a>
				</li>
				<li>
					<div class="dropdown-divider"></div>
				</li>
				<li>
					<div class="sidebar-small-cap">Extra</div>
				</li>
				<li>
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon bi bi-file-pdf"></span><span class="mtext">Documentation</span>
					</a>
					<ul class="submenu">
						<li><a href="<?= route_to('introduction') ?>">Introduction</a></li>
						<li><a href="<?= route_to('manual') ?>">Manual</a></li>
					</ul>
				</li>
				<li>
					<a
						href="<?= route_to('home') ?>"
						class="dropdown-toggle no-arrow">
						<span class="micon bi bi-house"></span>
						<span class="mtext">home page</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>