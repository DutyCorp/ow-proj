<link rel="stylesheet" type="text/css" href="{{asset('css/OWNavbar.css')}}">

<script src="{{asset('js/navbar.js')}}"></script>
<script type="text/javascript">
	$("#profilePicture").on('error', function () {
		$('#profilePicture').attr('src', "/a/{{ Crypt::encrypt('Face_Blue_128.png') }}");
	});
	$('.navigation').hide();
	setTimeout(function(){$('.navigation').show();}, 1);
	$("#OWFooter").load("{{ URL::to('OWFooter') }}");
</script>

<div class="modal fade bs-example-modal-sm" id="LogoutModal" tabindex="-1" role="dialog" aria-labelledby="LogoutModal">
	<div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	    	<center><br /><i class="fa fa-circle-o-notch fa-spin" style="font-size:36px;color:blue"></i> <br /> Logging out...<br /></center><br />
	    </div>
	</div>
</div>
<?php $count = 0; $count2 = 0; ?>
<section class="navigation">
  	<div class="nav-container">
    	<div class="brand">
      		<a href="/"><p id="Logo">owasia online</p></a>
    	</div>
    	<nav class="nav">
      		<div class="nav-mobile">
        		<a id="nav-toggle" href="#!"><span></span></a>
    		</div>
    		<ul class="nav-list">
	      	@foreach($menuparents as $menuparent)
				@if ($menuparent->MenuParentName != "Employee" && $menuparent->MenuParentName != "Home")
			        <li>
						<a href="#" class="sub1"><div class="text1">{{ $menuparent->MenuParentName }}</div><div class="drop1" style="display: inline;">&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></div></a>
						@foreach($submenus as $submenu)
							@if ($submenu->MenuParentID == $menuparent->MenuParentID)
								<?php $count++; ?>
							@endif
						@endforeach
						@if ($count > 0)
							<ul class="nav-dropdown nav1">
								@foreach($submenus as $submenu)
									@if ($submenu->MenuParentID == $menuparent->MenuParentID)
										<li>
										@if ($submenu->SubMenuName != "")
											@if ($submenu->SubMenuPath == "#")
												<a href="{{ URL::to($submenu->SubMenuPath) }}" class="sub2"><div class="text2">{{ $submenu->SubMenuName }}</div><div class="drop2" style="display: inline;">&nbsp;&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></div></a>
											@else
												<a href="{{ URL::to($submenu->SubMenuPath) }}" class="sub2">{{ $submenu->SubMenuName }}</a>
											@endif
											@foreach ($menuchilds as $menuchild)
												@if ($menuchild->SubMenuID == $submenu->SubMenuID)
													<?php $count2++; ?>
												@endif
											@endforeach
											@if ($count2 > 0)
											<ul class="nav-dropdown nav2">
												@foreach ($menuchilds as $menuchild)
													@if ($menuchild->SubMenuID == $submenu->SubMenuID)
														<li>
														@if ($menuchild->MenuChildName != "")
															<a href="{{ URL::to($menuchild->MenuPath) }}" class="sub3">{{ $menuchild->MenuChildName }}</a>
														@endif
														</li>
													@endif
												@endforeach
											</ul>
											@endif
											<?php $count2 = 0; ?>
										@endif
										</li>
									@endif
								@endforeach
				     		</ul>
			      		@endif
			          	<?php $count = 0; ?>
			        </li>
			    @endif
			@endforeach
			@foreach($menuparents as $menuparent)
				@if ($menuparent->MenuParentName == "Employee")
			        <li>
						<a href="#" class="sub1"><div class="text1">{{ $menuparent->MenuParentName }}</div><div class="drop1" style="display: inline;">&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></div></a>
						@foreach($submenus as $submenu)
							@if ($submenu->MenuParentID == $menuparent->MenuParentID)
								<?php $count++; ?>
							@endif
						@endforeach
						@if ($count > 0)
							<ul class="nav-dropdown nav1">
								@foreach($submenus as $submenu)
									@if ($submenu->MenuParentID == $menuparent->MenuParentID)
										<li>
										@if ($submenu->SubMenuName != "")
											@if ($submenu->SubMenuPath == "#")
												<a href="{{ URL::to($submenu->SubMenuPath) }}" class="sub2"><div class="text2">{{ $submenu->SubMenuName }}</div><div class="drop2" style="display: inline;">&nbsp;&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></div></a>
											@else
												<a href="{{ URL::to($submenu->SubMenuPath) }}" class="sub2"><div class="text2">{{ $submenu->SubMenuName }}</div></a>
											@endif
											@foreach ($menuchilds as $menuchild)
												@if ($menuchild->SubMenuID == $submenu->SubMenuID)
													<?php $count2++; ?>
												@endif
											@endforeach
											@if ($count2 > 0)
											<ul class="nav-dropdown nav2">
												@foreach ($menuchilds as $menuchild)
													@if ($menuchild->SubMenuID == $submenu->SubMenuID)
														<li>
														@if ($menuchild->MenuChildName != "")
															<a href="{{ URL::to($menuchild->MenuPath) }}" class="sub3">{{ $menuchild->MenuChildName }}</a>
														@endif
														</li>
													@endif
												@endforeach
											</ul>
											@endif
											<?php $count2 = 0; ?>
										@endif
										</li>
									@endif
								@endforeach
				          	</ul>
			          	@endif
			          	<?php $count = 0; ?>
			        </li>
			    @endif
			@endforeach
					<li>
						<a href="#" class="sub1"><img src="{{ session()->get('Photo') }}" id="profilePicture">&nbsp;&nbsp;{{ session()->get('EmployeeName') }}<div class="drop1" style="display: inline;">&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></div></a>
						<ul class="nav-dropdown nav1">
							<li>
								<a href="{{ URL::to('profile') }}"><i class="fa fa-user" aria-hidden="true" class="sub2"></i> Profile</a>
					    		<a href="{{ URL::to('changepassword') }}"><i class="fa fa-cog" aria-hidden="true" class="sub2"></i> Change Password</a>
					    		<a href="#" id="logout"><i class="fa fa-sign-out" aria-hidden="true" class="sub2"></i> Logout</a>
							</li>
				        </ul>
				   </li>
	      	</ul>
    	</nav>
  	</div>
</section>
