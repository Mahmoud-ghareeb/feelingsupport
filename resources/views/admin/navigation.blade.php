<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached">
	<div class="leftbar-user">
		<a href="javascript: void(0);">
			<img src="{{asset(auth()->user()->picture)}}" alt="user-image" height="42" class="rounded-circle shadow-sm">
			<span class="leftbar-user-name">{{auth()->user()->name}}</span>
		</a>
	</div>

	<!--- Sidemenu -->
	<ul class="metismenu side-nav side-nav-light">

		<li class="side-nav-title side-nav-item">navigation</li>

		<li class="side-nav-item">
			<a href="{{route('admin.dashboard');}}" class="side-nav-link">
				<i class="dripicons-view-apps"></i>
				<span>dashboard</span>
			</a>
		</li>
		@can('adminPermission', auth()->user())
		<li class="side-nav-item">
			<a href="javascript: void(0);" class="side-nav-link">
				<i class="fa-solid fa-face-grin"></i>
				<span class="menu-arrow"></span>
				<span>Emojis</span>
			</a>
			<ul class="side-nav-second-level" aria-expanded="false">
				<li class="">
					<a href="{{route('admin.manage.emojis')}}" class="">manage emojis</a>
				</li>
				<li class="">
					<a href="{{route('admin.change.emojis.order')}}">change emojis order</a>
				</li>
				<li class="">
					<a href="{{route('admin.add.emojis')}}">add new emoji</a>
				</li>
			</ul>
		</li>
		@endcan
		@can('superAdminPermission', auth()->user())
		<li class="side-nav-item">
			<a href="javascript: void(0);" class="side-nav-link">
				<i class="dripicons-box"></i>
				<span> users </span>
				<span class="menu-arrow"></span>
			</a>
			<ul class="side-nav-second-level" aria-expanded="false">
				@can('rootPermission', auth()->user())
				<li class="side-nav-item">
					<a href="javascript: void(0);" class="" aria-expanded="false">admins
						<span class="menu-arrow"></span>
					</a>
					<ul class="side-nav-third-level" aria-expanded="false">
						<li class="">
							<a href="{{route('admin.manage.admins')}}" class="">manage admins</a>
						</li>
						<li class="">
							<a href="{{route('admin.add.admins')}}">add new admin</a>
						</li>
					</ul>
				</li>
				@endcan
				@can('superAdminPermission', auth()->user())
				<li class="side-nav-item">
					<a href="javascript: void(0);" class="" aria-expanded="false">users
						<span class="menu-arrow"></span>
					</a>
					<ul class="side-nav-third-level" aria-expanded="false">
						<li class="">
							<a href="{{route('admin.manage.users')}}" class="">manage users</a>
						</li>
						<li class="">
							<a href="{{route('admin.add.users')}}">add new user</a>
						</li>
					</ul>
				</li>
				@endcan
			</ul>
		</li>
		@endcan
		@can('moderatorPermission', auth()->user())
		<li class="side-nav-item">
			<a href="{{route('admin.notification');}}" class="side-nav-link">
				<i class="fa-solid fa-paper-plane"></i>
				<span>Send notification</span>
			</a>
		</li>
		<li class="side-nav-item">
			<a href="javascript: void(0);" class="side-nav-link">
				<i class="dripicons-toggles"></i>
				<span class="menu-arrow"></span>
				<span>Settings</span>
			</a>
			<ul class="side-nav-second-level" aria-expanded="false">
				<li class="">
					<a href="{{config('app.url')}}/admin/translations" class="">languages</a>
				</li>
			</ul>
		</li>
		@endcan
	</ul>
</div>