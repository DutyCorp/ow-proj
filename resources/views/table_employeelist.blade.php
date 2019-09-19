@foreach ($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
	<script src="{{asset('js/TableEmployeeList.js')}}"></script>
	<table id="employeeListTable" class="table table-bordered" style="font-size:12px">
		<thead style="background-color:#ECECEC;font-weight:bold">
			<tr>
				<td>Employee ID</td>
				<td>Employee_Name</td>
				<td>Email</td>
				<td>Region</td>
				<td>Department</td>
				<td>Employee_Position</td>
				<td>Mobile Phone</td>
				<td>Skype ID</td>
				<td>Tenure</td>
				<td>Termination Date</td>
				<td>Start_Working_Date</td>
				<td>Date_of_Birth</td>
				<td>Emergency Contact</td>
				<td>National ID</td>
				<td>Tax Registration ID</td>
				<td>Passport</td>
				<td>CV</td>
				<td>Family Registration Card</td>
				<td>Photo</td>
				@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
				<td>Action_Button</td>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($ListEmployee as $Employee)
			<tr>
				<td>{{ $Employee->EmployeeID }}</td>
				<td>{{ $Employee->EmployeeName }}</td>
				<td>{{ $Employee->Email }}</td>
				<td>{{ $Employee->RegionName }}</td>
				<td>{{ $Employee->DepartmentName }}</td>
				<td>{{ $Employee->PositionName }}</td>
				<td>{{ $Employee->MobilePhone }}</td>
				<td>{{ $Employee->SkypeID }}</td>
				<td>{{ $Employee->Tenure }}</td>
				<td>{{ $Employee->TerminationDate }}</td>
				<td>{{ date('D d-M-Y', strtotime($Employee->StartWorkingDate))}}</td>
				<td>{{ date('D d-M-Y', strtotime($Employee->DateOfBirth))}}</td>
				<td>{{ $Employee->EmergencyContact }}</td>
				@if($rolemenu->Role_U == "1")
				@if($Employee->NationalID == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->NationalID).'') }}"><button value="{{ $Employee->NationalID }}" class="btnNationalID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->TaxID == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->TaxID).'') }}"><button value="{{ $Employee->TaxID }}" class="btnTaxID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->Passport == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Passport).'') }}"><button value="{{ $Employee->Passport }}" class="btnPassport btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->CV == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->CV).'') }}"><button  value="{{ $Employee->CV }}" class="btnCV btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->FamilyRegistrationCard == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->FamilyRegistrationCard).'') }}"><button value="{{ $Employee->FamilyRegistrationCard }}" class="btnKK btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->Photo == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Photo).'') }}"><button value="{{ $Employee->Photo }}" class="btnPhoto btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@else
				@if($Employee->EmployeeID == session()->get('EmployeeID'))
				@if($Employee->NationalID == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->NationalID).'') }}"><button value="{{ $Employee->NationalID }}" class="btnNationalID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->TaxID == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->TaxID).'') }}"><button value="{{ $Employee->TaxID }}" class="btnTaxID btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->Passport == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Passport).'') }}"><button value="{{ $Employee->Passport }}" class="btnPassport btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->CV == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->CV).'') }}"><button  value="{{ $Employee->CV }}" class="btnCV btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->FamilyRegistrationCard == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->FamilyRegistrationCard).'') }}"><button value="{{ $Employee->FamilyRegistrationCard }}" class="btnKK btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@if($Employee->Photo == "")
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@else
				<td><a href="{{ URL::to('dl/'.Crypt::encrypt($Employee->Photo).'') }}"><button value="{{ $Employee->Photo }}" class="btnPhoto btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button></a></td>
				@endif
				@else
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				<td><button class="btn" disabled><i class="fa fa-download" aria-hidden="true"></i></button></td>
				@endif
				@endif
				@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
				<td>
					@if ($rolemenu->Role_U == "1")
					<a href="/employee/setting/{{ Crypt::encrypt($Employee->EmployeeID) }}"><button class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
					@endif
					@if ($rolemenu->Role_D == "1")
					<button value="{{ $Employee->EmployeeID }}" class="ChooseDeleteEmployee btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
					@endif
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
@endforeach