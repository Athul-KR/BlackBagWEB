@if($searchResultList)
@foreach($searchResultList as $search)

  <tr>
    <td style="width:20%">
    <?php
      $corefunctions = new \App\customclasses\Corefunctions;
      if($search['logo_path'] !=''){
        $search['logo_path'] = ( $search['logo_path'] != '' ) ? $corefunctions->getAWSFilePath($search['logo_path']) : '';
      }
    ?>
    
      <a class="primary"  href="{{ $search['user_type_id'] == 2 ? url('user/'.$search['uuId'].'/details') :($search['user_type_id'] == 3 ? url('user/'.$search['uuId'].'/details'): url('patient/'.$search['uuId'].'/details')) }}">
      <div class="user_inner">
        <img @if($search['logo_path'] !='') src="{{($search['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif >
        <div class="user_info">
          <h6 class="primary fw-medium m-0">{{ $search['name'] }}</h6>
          <p class="m-0">{{ $search['email'] }}</p>
        </div>
       
      </div>
      <a>
    </td>
    <td style="width:10%">
      <p>
        {{ 
          $search['user_type_id'] == 2 ? 'Doctor' : 
          ($search['user_type_id'] == 3 ? 'Nurse' : 
          ($search['user_type_id'] == 1 ? 'Clinic' : 'Patient'))   
        }}
     </p>
    </td>

    <td style="width:15%"><a class="primary"> @if(isset($countryCode[$search['country_code']]['country_code'])) {{$countryCode[$search['country_code']]['country_code']}} @else  @endif {{ $search['phone_number'] }} <a></td>

    <td style="width:10%">
        <a class="primary">
            @if( isset($search['department']))
            {{$search['department']}}
            @else
            --
            @endif
            <a>
    </td>
    <td style="width:10%">
        <a class="primary">
            @if( !empty($designations) && isset($designations[$search['designation_id']]) && isset($designations[$search['designation_id']]['name']))
            {{$designations[$search['designation_id']]['name']}}
            @else
            --
            @endif
            <a>
    </td>

    <td style="width:20%"><a class="primary"  >@if(isset($speciality[$search['specialty_id']])) {{ $speciality[$search['specialty_id']]['specialty_name']}} @else No Specialty @endif <a></td>
  </tr>
@endforeach
@else
@if($isLoadMore != '1')
<tr class="text-center">
  <td colspan="8">
      <div class="flex justify-center">
          <div class="text-center no-records-body">
              <img src="{{asset('images/nodata.png')}}"
                  class=" h-auto">
              <p>No records found</p>
          </div>
      </div>
  </td>
</tr>
@endif
@endif
{{-- <div class="col-md-6">
    {{ $searchResult->links('pagination::bootstrap-5') }}
</div> --}}