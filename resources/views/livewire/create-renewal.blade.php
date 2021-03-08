<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-8">
                    @if($errors->any())
                        @include('errors')
                    @endif
                    @if(session('message'))
                        <div class="alert alert-success alert-rounded col-md-12"><i
                                class="fa fa-check-circle"></i> {{session('message')}}
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2"></div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <form wire:submit.prevent="make_payment()" enctype="multipart/form-data" method="post"
                          class="m-t-40"
                          novalidate>
                        {{csrf_field()}}
                        @if($step == 0)
                            <div class="card ">
                                <div class="card-header card-primary">
                                    {{date('Y')}} renewal
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" style="color: black; font-weight: bolder;">Renewal</h5>
                                    <p class="card-text">{{$message}}</p>
                                    <div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div>
                                                    <div class="form-group"><!--I removed wire ignore -->
                                                        <label style="color: black;font-weight: bolder;">Date Of
                                                            Birth</label>
                                                        @if($dob == null)
                                                            <p style="color: yellowgreen;">{{'Please enter your date of birth first before your proceed!'}}</p>
                                                        @elseif($dob != null && $age <= 18)
                                                            <p style="color: red;">{{'Please enter a valid dirt of birth, you cannot be under  the age of 18!'}}</p>

                                                        @else
                                                            <p style="color: #9acd32;">{{'Confirm date of birth, or enter one if you did not submit before!'}}</p>

                                                        @endif

                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">D.O.B @if($dob != null)
                                                                        ({{$age}})@endif</span>
                                                            </div>
                                                            <input wire:model="dob" type="text"
                                                                   class="form-control datepicker"
                                                                   aria-label="Dirt Of Birth" id="dp"
                                                                   value="{{$practitioner->dob}}"
                                                                   onclick="myDatePicker()"
                                                                   data-provide="datepicker" data-date-autoclose="true"
                                                                   data-date-format="yyyy-mm-dd"
                                                                   data-date-today-highlight="true"
                                                                   onchange="this.dispatchEvent(new InputEvent('input'))"
                                                            >
                                                        </div>
                                                        <span
                                                            style="color: red;">@error('dob'){{$message}}@enderror</span>
                                                    </div>

                                                </div>
                                                <hr/>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <h5 style="color: black; font-weight: bolder">Employment Status</h5>
                                                <p style="color: yellowgreen;">Please choose your employment status.</p>
                                                @foreach($employment_statuses as $employment_status)
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input wire:model="employment_status_id"
                                                                   class="form-check-input"
                                                                   type="radio"
                                                                   name="employment_status_id"
                                                                   id="exampleRadios1"
                                                                   value="{{$employment_status->id}}">
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                {{$employment_status->name}}
                                                            </label>
                                                            <p style="color: yellowgreen;">{{$employment_status->description}}</p>
                                                        </div>
                                                    </div>

                                                @endforeach
                                                <span
                                                    style="color: red;">@error('employment_status_id'){{$message}}@enderror</span>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <h5 style="color: black; font-weight: bolder">Residence</h5>
                                                <p style="color: yellowgreen;">Choose if one should be either foreign
                                                    based
                                                    or local based</p>
                                                @foreach($employment_locations as $employment_location)
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input wire:model="employment_location_id"
                                                                   class="form-check-input"
                                                                   type="radio"
                                                                   name="employment_location_id"
                                                                   id="exampleRadios1"
                                                                   value="{{$employment_location->id}} {{old('employment_location')}}">
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                {{$employment_location->name}}
                                                            </label>
                                                            <p style="color: yellowgreen;">{{$employment_location->description}}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if ($errors->any()) <span
                                                    style="color: red;"> @error('employment_location_id'){{$message}}@enderror </span>@endif

                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <h5 style="color: black; font-weight: bolder">Certificate request</h5>
                                                <p style="color: yellowgreen;">Please specify if a certificate can be
                                                    issued
                                                    in
                                                    this criteria.</p>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input wire:model="certificate_request" class="form-check-input"
                                                               type="radio"
                                                               name="certificate_request"
                                                               id="exampleRadios1" value="1">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            {{'Yes'}}
                                                        </label>
                                                        <p style="color: yellowgreen;">{{'A certificate is to be issued'}}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input wire:model="certificate_request" class="form-check-input"
                                                               type="radio"
                                                               name="certificate_request"
                                                               id="exampleRadios1" value="2">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            {{'No'}}
                                                        </label>
                                                        <p style="color: yellowgreen;">{{'A certificate is not to be issued'}}</p>
                                                    </div>
                                                </div>
                                                @if ($errors->any())<span
                                                    style="color: red;">@error('certificate_request'){{$message}}@enderror</span>@endif


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endif

                        @if($step == 1)

                            <div class="card ">
                                <div class="card-header card-primary">
                                    CPD Points
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Required CPD Points
                                        : @if($cpd_criteria !=null){{$cpd_criteria->points}}@endif</h5>

                                    <p class="card-text" style="color: yellowgreen">Please note that, you are required
                                        to submit the copy
                                        of
                                        CPD book, if you are foreign you may submit your current registration
                                        from
                                        your country of residents.</p>
                                    <div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">CPD Points </span>
                                            </div>
                                            <input wire:model="points" type="text" class="form-control"
                                                   aria-label="CPD Points">
                                        </div>
                                        @if ($errors->any())<span
                                            style="color: red;">@error('points'){{$message}}@enderror</span>@endif
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-book-open"></i> CPD Book </span>
                                            </div>
                                            <input wire:model="path" type="file" required class="form-control"
                                                   aria-label="CPD Points">
                                        </div>
                                        @if ($errors->any())<span
                                            style="color: red;">@error('file'){{$message}}@enderror</span>@endif

                                    </div>
                                </div>
                            </div>

                            <hr/>
                        @endif

                        @if($step == 2)

                            <div class="card ">
                                <div class="card-header card-primary">
                                    Renewal Payment
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{date('Y')}} Renewal Payment</h5>
                                    <p class="card-text" style="color: yellowgreen">Please note that, you are required
                                        make full payment in order to get your certificate processed.</p>
                                    <div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="wlocation2"> Period : <span
                                                        class="danger">*</span>
                                                </label>
                                                <select wire:model="period" class="custom-select form-control " required
                                                        name="period">
                                                    <option value="">Choose period</option>
                                                    @for($x =date('Y')+10;$x >= 2008;$x--)
                                                        <option value="{{$x}}">{{$x}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('period'){{$message}}@enderror </span>
                                            @endif

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="wlocation2"> Payment Channel : <span
                                                        class="danger">*</span>
                                                </label>
                                                <select wire:model="payment_channel_id"
                                                        class="custom-select form-control"
                                                        onchange="myPaymentChannels()" required
                                                        id="payment_channel_id" name="payment_channel_id">
                                                    <option value="">Payment Channel</option>
                                                    @foreach($payment_channels as $payment_channels)
                                                        <option
                                                            value="{{$payment_channels->id}}" @if($payment_channels->id==old('payment_channels')){{'selected'}}@endif>{{$payment_channels->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('payment_channel_id'){{$message}}@enderror </span>@endif

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Amount Invoiced</label>
                                                <input wire:model="amount_invoiced" type="number" step="any" disabled
                                                       name="amount_invoiced" class="form-control">
                                            </div>
                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('amount_invoiced'){{$message}}@enderror </span>@endif

                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Amount Paid</label>
                                                <input wire:model="amount_paid" type="number" step="any"
                                                       name="amount_paid"
                                                       value="" class="form-control"
                                                       id="">
                                            </div>
                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('amount_paid'){{$message}}@enderror </span>@endif

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Payment Date</label>
                                                <input wire:model="payment_date" type="text" name="payment_date"
                                                       value="" class="form-control" id="payment_date"
                                                       onclick="myPaymentDate()"
                                                       onclick="myDatePicker()"
                                                       data-provide="payment_date" data-date-autoclose="true"
                                                       data-date-format="yyyy-mm-dd"
                                                       data-date-today-highlight="true"
                                                       onchange="this.dispatchEvent(new InputEvent('input'))"
                                                >
                                            </div>

                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('payment_date'){{$message}}@enderror </span>@endif

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label>Receipt Number</label>
                                                <input wire:model="receipt_number" type="number" step="any"
                                                       name="receipt_number"
                                                       value="" class="form-control"
                                                       id="">
                                            </div>
                                            @if ($errors->any()) <span
                                                style="color: red;"> @error('receipt_number'){{$message}}@enderror </span>@endif

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <hr/>
                        @endif
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <a href="#" wire:click.prevent="decrease_step" class="btn btn-primary btn-block"
                                   style="color: white;">Previous</a>
                            </div>
                            @if($step == 2)
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <button class="btn btn-success btn-block">Submit</button>
                                </div>
                            @else
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <a href="#" wire:click.prevent="increase_step" class="btn btn-success btn-block"
                                       style="color: white;">Next</a>
                                </div>
                            @endif
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

