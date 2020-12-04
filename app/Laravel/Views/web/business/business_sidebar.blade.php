<div class="col-md-3">
    <div class="card text-center">
        <div class="card-body">
            <img class="card-img-top avatar-preview" src="{{asset('placeholder/user.png')}}" alt="Card image cap">
            <h5 class="card-title">{{$auth->full_name}}</h5>
           
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body text-center">
            <h5 class="sd-title">My Business CV's</h5>
            <a href="{{route('web.business.create')}}" class="custom-btn badge-primary-2 text-white">Add Business CV</a>
        </div>
         <div class="card-body text-center">
            @forelse($business_profiles as $index)
            <a href="{{route('web.business.profile',[$index->id])}}" >{{Str::title($index->business_name)}}<i class="fa fa-fw fa-eye ml-2 mt-1"></i></a>
            @empty
            @endforelse
        </div>
    </div>
</div>