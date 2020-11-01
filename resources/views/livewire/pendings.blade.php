<div class="tab-content">
    <div class="tab-pane active" id="approved" role="tabpanel">
        <div class="card-body">

            <h4 class="card-title">Practitioners Pending Approval</h4>
            <form>
                <div class="col-md-6 form-group">
                    <label for="formGroupExampleInput">Search Practitioner</label>
                    <input wire:model="searchTerm" type="text" class="form-control" id="formGroupExampleInput" placeholder="Search By First Name or Last Name or registration Number">
                </div>

            </form>
            <div class="table-responsive m-t-40">
                <table id="practitioners"
                       class="display table table-hover table-striped table-bordered"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Practitioner Name</th>
                        <th>Registration Number</th>
                        <th>Profession</th>
                        <th>Professional Qualification</th>
                        {{--<th>Qualification Category</th>--}}
                        <th>Accredited Institution</th>
                        <th>Status</th>
                        <th>view</th>
                        @can('updatePractitioner')
                            <th>Delete</th>
                        @endcan
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Practitioner Name</th>
                        <th>Registration Number</th>
                        <th>Profession</th>
                        <th>Professional Qualification</th>
                        {{--<th>Qualification Category</th>--}}
                        <th>Accredited Institution</th>
                        <th>Status</th>
                        <th>view</th>
                        @can('updatePractitioner')
                            <th>Delete</th>
                        @endcan
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($practitioners as $practitioner)
                        <tr>
                            <td>{{$practitioner->title->name}}</td>
                            <td>{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
                            <td>
                                @if($practitioner->registration_number == null)
                                    {{$practitioner->prefix.' (No Registration Number)'}}
                                @else
                                    {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                                @endif
                            </td>
                            <td>{{$practitioner->profession->name}}</td>
                            <td> @if($practitioner->professional_qualification_id !=null){{$practitioner->professionalQualification->name}}@endif</td>
                            <td>
                                @if($practitioner->qualification_category_id == 1)
                                    @if($practitioner->accreditedInstitution)
                                        {{$practitioner->accreditedInstitution->name}}
                                    @endif
                                @else
                                    {{$practitioner->institution}}
                                @endif
                            </td>
                            <td>
                                @if($practitioner->currentRenewal)
                                    @if (($practitioner->currentRenewal->renewal_status_id == 1) && ($practitioner->currentRenewal->cdpoints == 1) && ($practitioner->currentRenewal->placement == 1))
                                        {{'Compliant'}}
                                    @else
                                        {{'Not Compliant'}}
                                    @endif
                                @else
                                    {{'Not Compliant'}}
                                @endif
                            </td>

                            <td>
                                <a href="/admin/practitioners/{{$practitioner->id}}">View</a> |
                                <a href="/admin/practitioners/renewals/{{$practitioner->id}}/checkPaymentStatusRenewal">
                                    Renew</a>
                            </td>
                            @can('updatePractitioner')
                                <td><a href="/admin/practitioners/{{$practitioner->id}}/delete">
                                        Delete</a></td>
                            @endcan
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{ $practitioners->links('livewire.livewire-pagination') }}
            </div>
        </div>
    </div>

    {{-- <div class="tab-pane" id="pending" role="tabpanel">
         <div class="card-body">
             <h4 class="card-title">Practitioners</h4>
             <form>
                 <div class="col-md-6 form-group">
                     <label for="formGroupExampleInput">Search Practitioner</label>
                     <input wire:model="searchTermPending" type="text" class="form-control" id="formGroupExampleInput" placeholder="Search By First Name or Last Name or registration Number">
                 </div>

             </form>
             <div class="table-responsive m-t-40">
                 <table id="pendings"
                        class="display table table-hover table-striped table-bordered"
                        cellspacing="0" width="100%">
                     <thead>
                     <tr>
                         <th>Title</th>
                         <th>Practitioner Name</th>
                         <th>Registration Number</th>
                         <th>Profession</th>
                         <th>Professional Qualification</th>
                         <th>Qualification Category</th>
                         <th>Accredited Institution</th>
                         <th>Status</th>
                         <th>view</th>
                         @can('updatePractitioner')
                             <th>Delete</th>
                         @endcan
                     </tr>
                     </thead>
                     <tfoot>
                     <tr>
                         <th>Title</th>
                         <th>Practitioner Name</th>
                         <th>Registration Number</th>
                         <th>Profession</th>
                         <th>Professional Qualification</th>
                         <th>Qualification Category</th>
                         <th>Accredited Institution</th>
                         <th>Status</th>
                         <th>view</th>
                         @can('updatePractitioner')
                             <th>Delete</th>
                         @endcan
                     </tr>
                     </tfoot>
                     <tbody>
                     @foreach($pendings as $practitioner)
                         <tr>
                             <td>{{$practitioner->title->name}}</td>
                             <td>{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
                             <td>
                                 @if($practitioner->registration_number == null)
                                     {{$practitioner->prefix.' (No Registration Number)'}}
                                 @else
                                     {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                                 @endif
                             </td>
                             <td>{{$practitioner->profession->name}}</td>
                             <td> @if($practitioner->professional_qualification_id !=null){{$practitioner->professionalQualification->name}}@endif</td>
                             <td>
                                 @if($practitioner->qualification_category_id == 1)
                                     @if($practitioner->accreditedInstitution)
                                         {{$practitioner->accreditedInstitution->name}}
                                     @endif
                                 @else
                                     {{$practitioner->institution}}
                                 @endif
                             </td>
                             <td>
                                 @if($practitioner->currentRenewal)
                                     @if (($practitioner->currentRenewal->renewal_status_id == 1) && ($practitioner->currentRenewal->cdpoints == 1) && ($practitioner->currentRenewal->placement == 1))
                                         {{'Compliant'}}
                                     @else
                                         {{'Not Compliant'}}
                                     @endif
                                 @else
                                     {{'Not Compliant'}}
                                 @endif
                             </td>

                             <td>
                                 <a href="/admin/practitioners/{{$practitioner->id}}">View</a> |
                                 <a href="/admin/practitioners/renewals/{{$practitioner->id}}/checkPaymentStatusRenewal">
                                     Renew</a>
                             </td>
                             @can('updatePractitioner')
                                 <td><a href="/admin/practitioners/{{$practitioner->id}}/delete">
                                         Delete</a></td>
                             @endcan
                         </tr>
                     @endforeach
                     </tbody>
                 </table>
                 {{ $pendings->links('livewire.livewire-pagination2') }}
             </div>
         </div>
     </div>--}}
</div>
{{--
@section('plugins-js')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#practitioners').DataTable({
                order: [],
                dom: 'Bfrtip',
                paging:false,
            });


        })

    </script>
@stop
--}}

