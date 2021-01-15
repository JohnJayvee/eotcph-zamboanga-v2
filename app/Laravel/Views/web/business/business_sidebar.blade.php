<div class="col-md-3">
    <div class="card text-center">
        <div class="card-body">
            <img class="card-img-top avatar-preview" src="{{asset('placeholder/user.png')}}" alt="Card image cap">
            <h5 class="card-title">{{$auth->full_name}}</h5>

        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body text-center">
            <a href="{{route('web.business.create')}}" class="custom-btn badge-primary-2 text-white">Add Business CV</a>

        </div>
         <ul class="list-group">
            <li class="list-group-item text-muted text-center">My Business CV's <i class="fa fa-dashboard fa-1x"></i></li>
            @forelse($business_profiles as $index)
            <li class="list-group-item text-left">
                <span class="pull-left">
                    <div class="row" style="align-items: center;">
                        <div class="col-md-9"><strong>{{Str::title($index->business_name)}} - {{$index->business_id_no}}</strong></div>
                        <div class="col-md-3">
                            <a href="{{route('web.business.profile',[$index->id])}}"><i class="fa fa-fw fa-eye ml-2 mt-1"></i></a>
                        </div>
                    </div>

                </span>
            </li>
            @empty
            @endforelse
          </ul>
    </div>
</div>
