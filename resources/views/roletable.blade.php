<table id="tableRoleAccess" class="table table-bordered" style="font-size: 10px; background-color: #FFFFFF;">
	<thead>
		<tr>
			<td>Menu</td>
			<td>Sub Menu</td>
			<td>Menu Child</td>
			<td>Show</td>
			<td>Insert</td>
			<td>Update</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			$menucount = 0; 
		?>
		@foreach($menus as $menu)
			<tr id="{{ $menu->MenuChildID }}" value="{{ $menu->MenuChildID }}">
				<td>{{ $menu->MenuParentName }}</td>
				<td>{{ $menu->SubMenuName }}</td>
				<td>{{ $menu->MenuChildName }}/td>
				@if (!empty(array($rolemenus[$menucount])))
					@foreach($rolemenus as $rolemenu)
						@if ($rolemenu->MenuChildID == $menu->MenuChildID)
							@if ($rolemenu->Role_S == 1)
								@if ($menu->Menu_S == 1)
									<td><input type="checkbox" checked="true"></td>
								@else
									<td><input type="checkbox" checked="true" disabled></td>
								@endif
							@else
								@if ($menu->Menu_S == 1)
									<td><input type="checkbox"></td>
								@else
									<td><input type="checkbox" disabled></td>
								@endif
							@endif
							@if ($rolemenu->Role_I == 1)
								@if ($menu->Menu_I == 1)
									<td><input type="checkbox" checked="true"></td>
								@else
									<td><input type="checkbox" checked="true" disabled></td>
								@endif
							@else
								@if ($menu->Menu_I == 1)
									<td><input type="checkbox"></td>
								@else
									<td><input type="checkbox" disabled></td>
								@endif
							@endif
							@if ($rolemenu->Role_U == 1)
								@if ($menu->Menu_U == 1)
									<td><input type="checkbox" checked="true"></td>
								@else
									<td><input type="checkbox" checked="true" disabled></td>
								@endif
							@else
								@if ($menu->Menu_U == 1)
									<td><input type="checkbox"></td>
								@else
									<td><input type="checkbox" disabled></td>
								@endif
							@endif
							@if ($rolemenu->Role_D == 1)
								@if ($menu->Menu_D == 1)
									<td><input type="checkbox" checked="true"></td>
								@else
									<td><input type="checkbox" checked="true" disabled></td>
								@endif
							@else
								@if ($menu->Menu_D == 1)
									<td><input type="checkbox"></td>
								@else
									<td><input type="checkbox" disabled></td>
								@endif
							@endif
						@endif
					@endforeach
				@else
					@if ($menu->Menu_S == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_I == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_U == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_D == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
				@endif
				@if(json_decode($rolemenus, true) == null)
					@if ($menu->Menu_S == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_I == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_U == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($menu->Menu_D == 1)
						<td><input type="checkbox"></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					<!--<td><input type="checkbox"></td>
					<td><input type="checkbox"></td>
					<td><input type="checkbox"></td>-->
				@endif
				<?php $menucount++; ?>
			</tr>
		@endforeach
	</tbody>
</table>