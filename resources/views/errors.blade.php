
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="text-center">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <small><b>Check Errors</b></small>
                </h3>
            </div>
            <div class="panel-body">

                <ul class="list-group">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <li class="list-group-item">
                                {{$error}}
                            </li>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>
<br/>


