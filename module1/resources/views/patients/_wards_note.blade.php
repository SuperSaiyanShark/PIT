{{-- 
  NOTE: The admitModal's select for WardID needs the $wards variable.
  In PatientController@show, add this line before returning the view:
  
    $wards = \App\Models\Ward::orderBy('WardName')->get();
    return view('patients.show', compact('patient', 'wards'));
  
  Then in the admitModal replace the <select> block with:
  
    <select name="WardID" required>
        <option value="">Select a ward</option>
        @foreach($wards as $ward)
            <option value="{{ $ward->WardID }}">
                {{ $ward->WardName }} ({{ $ward->available_beds }} beds available)
            </option>
        @endforeach
    </select>
--}}
