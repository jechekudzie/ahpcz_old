<div>
    <div class="w-full flex pb-10">
        <div class="w-3/6 mx-1">
            <input wire:model.debounce.300ms="search" type="text"
                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                   placeholder="Search practitioners by name, reg number, or profession ...">
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderBy"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="id">Sort By</option>
                <option value="last_name">Names</option>
                <option value="prefix">Professions</option>
                <option value="registration_number">Registration Number</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="certificate"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="0">General {{$certificate}}</option>
                <option value="1">With Certificate Number</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="compliance"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="">Filter By Status</option>
                <option value="1">Compliant</option>
                <option value="2">Non-Compliant</option>

            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderAsc"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option value="1">Ascending</option>
                <option value="0">Descending</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="perPage"
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
    </div>
    <table class="display table table-hover table-striped table-bordered table-auto w-full mb-6">
        <thead>
        <tr>
            <th class="px-4 py-2">Title</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Registration Number</th>
            <th class="px-4 py-2">Profession</th>
            <th class="px-4 py-2">Register</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Certificate no.</th>
            <th class="px-4 py-2">Actions</th>
            @can('updatePractitioner')
                <th class="px-4 py-2">Delete</th>
            @endcan

        </tr>
        </thead>
        <tbody>
        @foreach($practitioners as $practitioner)
            <tr>
                <td class="border px-4 py-2">
                    @if($practitioner->title){{ $practitioner->title->name
                }}@else{{'No Title'}}@endif
                </td>
                <td class="border px-4 py-2">{{ $practitioner->last_name.' '. $practitioner->first_name}}</td>
                <td class="border px-4 py-2">
                    @if($practitioner->registration_number == null)
                        {{$practitioner->prefix.' (No Registration Number)'}}
                    @else
                        {{$practitioner->prefix.str_pad($practitioner->registration_number, 4, '0', STR_PAD_LEFT)}}
                    @endif
                </td>
                <td class="border px-4 py-2">
                    @if( $practitioner->profession)
                        {{ $practitioner->profession->name }}
                    @endif
                </td>
                <td class="border px-4 py-2">
                    @if($practitioner->practitioner_payment_information)
                        @if($practitioner->practitioner_payment_information->register_category)
                            {{$practitioner->practitioner_payment_information->register_category->name}}
                        @endif
                    @endif
                </td>
                <td class="border px-4 py-2">
                    @if($practitioner->currentRenewal)
                        @if (($practitioner->currentRenewal->renewal_status_id == 1)
                            && ($practitioner->currentRenewal->cdpoints == 1)
                            && ($practitioner->currentRenewal->placement == 1))
                            {{'Compliant'}}
                        @else
                            {{'Non-Compliant'}}
                        @endif
                    @else
                        {{'Non-Compliant'}}
                    @endif
                </td>
                <td>@if($practitioner->currentRenewal)({{str_pad($practitioner->currentRenewal->certificate_number,
                4, '0', STR_PAD_LEFT)}})@else
                    {{'No number'}}
                        @endif

                </td>
                <td class="border px-4 py-2">
                    <a href="/admin/practitioners/{{$practitioner->id}}">View</a>

                    |
                    <a href="/admin/auto_renew/{{$practitioner->id}}">
                        Auto Renew</a>
                </td>
                @can('updatePractitioner')
                    <td class="border px-4 py-2"><a href="/admin/practitioners/{{$practitioner->id}}/delete">
                            Delete</a>
                    </td>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $practitioners->links() !!}

    <div>
        Showing {!! $practitioners->firstItem() !!} of {!! $practitioners->lastItem() !!} out
        of {!! $practitioners->total() !!}

    </div>
</div>
