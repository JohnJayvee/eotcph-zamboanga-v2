@extends('web._layouts.main')


@section('content')

<style>
    main {
        display: block;
    }
    .main-section {
        float: left;
        width: 100%;
    }
    .main-section-data {
    float: left;
    width: 100%;
    }
    .pd-left-none {
    padding-left: 0;
}
.fw {
    width: 100%;
    margin-bottom: 20px;
}
.title {
    font-weight: 600;
    font-size: 20px;
    color: #333;
}
p {
    font-size: 14px;
    line-height: 24px;
    color: #666666;
}
.no-margin {
    margin: 0 !important;
}
.main-left-sidebar {
    float: left;
    width: 100%;
    margin-top: -20px;
}
.user-data {
    text-align: center;
}
.full-width {
    float: left;
    width: 100%;
    background-color: #fff;
    margin-bottom: 20px;
    border-left: 1px solid #e5e5e5;
    border-right: 1px solid #e5e5e5;
    border-bottom: 1px solid #e5e5e5;
}
.user-profile {
    float: left;
    width: 100%;
}
.process-specs {
    float: left;
    width: 100%;
    padding: 15px 0 15px 0;
}
.img-icon {
    height: 60px;
    width: auto;
    margin: auto;
    float: none;
    margin-bottom: 10px;
}
img {
    max-width: 100%;
}
.user-profile h5 {
    font-size: 12px;
}
.user-fw-status {
    float: left;
    width: 100%;
}
ol, ul {
    list-style: none;
}
.dashboard-bg {
    background-color: #fff;
}
.username-dt {
    float: left;
    width: 100%;
    background-color: #0038A8;
    padding-top: 40px;
}
.user-specs {
    float: left;
    width: 100%;
    padding: 63px 0 27px 0;
}
.user-specs h3 {
    color: #000000;
    font-size: 24px;
    text-transform: capitalize;
    font-weight: 600;
    margin-bottom: 8px;
}
.user-fw-status li {
    padding: 5px 0;
    min-height: 35px;
}
.user-fw-status li {
    float: left;
    width: 100%;
    border-bottom: 1px solid #e5e5e5;
    border-top: 1px solid #e5e5e5;
    padding: 15px 0;
}
.sd-title {
    float: left;
    width: 100%;
    padding: 20px;
    border-bottom: 1px solid #e5e5e5;
    border-top: 1px solid #e5e5e5;
    position: relative;
    display: grid;
}
.sd-title h3 {
    color: #000000;
    font-size: 18px;
    font-weight: 600;
    float: left;
}
.sd-title.new-link {
    padding-top: 5px;
    padding-bottom: 5px;
    background: #f2f2f2;
    text-decoration: underline;
}
.suggestions-list {
    float: left;
    width: 100%;
    padding: 13px 0 30px 0;
}
.suggestion-usd {
    float: left;
    width: 100%;
    padding: 15px 20px;
}
.sgt-text {
    float: left;
    padding-left: 10px;
}
.suggestion-usd > span {
    float: right;
    margin-top: 4px;
    position: relative;
}
.sgt-text h4 {
    color: #000000;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
}
.sgt-text span {
    color: #686868;
    font-size: 14px;
}
.view-more {
    float: left;
    width: 100%;
    text-align: center;
    padding-top: 10px;
}
.view-more > a {
    color: #e44d3a;
    font-size: 14px;
    font-weight: 700;
}
.tags-sec {
    background-color: #fff;
    padding: 25px 5px;
}
.cp-sec {
    float: left;
    width: 100%;
    margin-top: 5px;
    padding: 0 13px;
}
.cp-sec > img {
    float: left;
    margin-top: 3px;
}
.cp-sec p {
    float: right;
    color: #b2b2b2;
    font-size: 14px;
    font-weight: 500;
}
.cp-sec p img {
    float: none;
    display: inline-block;
    position: relative;
    top: 3px;
    padding-right: 5px;
}
.main-ws-sec {
    float: left;
    width: 100%;
}
.post-topbar {
    border-top: 4px solid #0038A8;
}
.post-topbar {
    float: left;
    width: 100%;
    padding: 23px 20px;
    background-color: #fff;
    border-top: 4px solid #e44d3a;
    border-left: 1px solid #e4e4e4;
    border-bottom: 1px solid #e4e4e4;
    border-right: 1px solid #e4e4e4;
    -webkit-box-shadow: 0 0 1px rgba(0,0,0,0.24);
    -moz-box-shadow: 0 0 1px rgba(0,0,0,0.24);
    -ms-box-shadow: 0 0 1px rgba(0,0,0,0.24);
    -o-box-shadow: 0 0 1px rgba(0,0,0,0.24);
    box-shadow: 0 0 1px rgba(0,0,0,0.24);
    margin-bottom: 20px;
}
.posts-section {
    float: left;
    width: 100%;
}
.post-bar {
    float: left;
    width: 100%;
    background-color: #fff;
    border: 1px solid #e4e4e4;
    margin-bottom: 20px;
    padding: 20px;
    box-shadow: 0px 2px #e4e4e4;
}
.job_descp {
    float: left;
    width: 100%;
}
.job_descp h3 {
    color: #333;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
}
.ref-transaction {
    text-decoration: underline;
    font-weight: 400;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
}
.qr-holder {
    position: relative;
    width: 100%;
}
.qr-holder img {
    position: absolute;
    right: 5px;
    bottom: 0px;
    height: 70px;
}
</style>

<!--team section start-->
<section class="ptb-120 dashboard-bg">
    <main>
        <div class="main-section">
            <div class="container">
                <div class="main-section-data">
                    <div class="row">
                        <div class="col-lg-12 pd-left-none ">
                            <div class="fw">

                                <p class="title">oASAP DASHBOARD</p>
                                {{-- <p><small>Profile Completion Status</small></p> --}}
                            </div>
                        </div>
                        <div class="col-lg-12 pd-left-none no-margin mb-10">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 pd-left-none ">
                            <div class="main-left-sidebar no-margin">
                                <div class="user-data full-width">
                                    <div class="user-profile">
                                        <div class="process-specs">
                                            <a href="http://127.0.0.1:8000/dashboard/profile/edit">
                                                <img src="http://127.0.0.1:8000/placeholder/home/1.png" alt=""
                                                    class="img img-responsive img-icon">
                                            </a>
                                            <h5>Personal Information</h5>
                                        </div>
                                    </div>
                                    <!--user-profile end-->
                                    <ul class="user-fw-status">
                                        <li>
                                            <p class="text-success">Completed <i class="fa fa-check"></i></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 pd-left-none ">
                            <div class="main-left-sidebar no-margin">
                                <div class="user-data full-width">
                                    <div class="user-profile">
                                        <div class="process-specs">
                                            <a href="http://127.0.0.1:8000/dashboard/profile/edit-address">
                                                <img src="http://127.0.0.1:8000/placeholder/home/2.png" alt="" class="img img-responsive img-icon">
                                            </a>
                                            <h5>Address Information</h5>
                                        </div>
                                    </div>
                                    <!--user-profile end-->
                                    <ul class="user-fw-status">
                                        <li>
                                            <a href="http://127.0.0.1:8000/dashboard/profile/edit-address" title="">Complete Now!</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 pd-left-none ">
                            <div class="main-left-sidebar no-margin">
                                <div class="user-data full-width">
                                    <div class="user-profile">
                                        <div class="process-specs">
                                            <a href="http://127.0.0.1:8000/dashboard/profile/edit-employment">
                                                <img src="http://127.0.0.1:8000/placeholder/home/3.png" alt="" class="img img-responsive img-icon">
                                            </a>
                                            <h5>Employment Information</h5>
                                        </div>
                                    </div>
                                    <!--user-profile end-->
                                    <ul class="user-fw-status">
                                        <li>
                                            <a href="http://127.0.0.1:8000/dashboard/profile/edit-employment" title="">Complete Now!</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 pd-left-none ">
                            <div class="main-left-sidebar no-margin">
                                <div class="user-data full-width">
                                    <div class="user-profile">
                                        <div class="process-specs">
                                            <a href="http://127.0.0.1:8000/dashboard/business/verify">
                                                <img src="http://127.0.0.1:8000/placeholder/home/4.png" alt="" class="img img-responsive img-icon">
                                            </a>
                                            <h5>Business CV</h5>
                                        </div>
                                    </div>
                                    <!--user-profile end-->
                                    <ul class="user-fw-status">
                                        <li>
                                            <p class="text-success">Completed <i class="fa fa-check"></i></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 pd-left-none ">
                            <div class="main-left-sidebar no-margin">
                                <div class="user-data full-width">
                                    <div class="user-profile">
                                        <div class="username-dt"
                                            style="background-image: url(http://127.0.0.1:8000/placeholder/banner.jpg); background-size: cover;">

                                            <div class="avatar-upload mx-auto my-0">
                                                <a href="http://127.0.0.1:8000/dashboard/profile/edit-avatar">
                                                    <div class="avatar-edit" style="
                                                            position: absolute;
                                                            background: white;
                                                            padding: 10px;
                                                            border-radius: 20px;
                                                            right: 0;">
                                                        <i class="fas fa-pen text-black-50"></i>

                                                    </div>
                                                </a>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url(http://127.0.0.1:8000/placeholder/user.png);">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--username-dt end-->

                                        <div class="user-specs" style="margin-bottom: -20px;">
                                            @if(Auth::guard('customer')->user())
                                            <h3>{{Str::title(Auth::guard('customer')->user()->fname)}}</h3>
                                            @else
                                            <h3>Login to Show</h3>
                                            @endif
                                        </div>
                                    </div>
                                    <!--user-profile end-->
                                    <ul class="user-fw-status">
                                        <li>
                                            <a href="http://127.0.0.1:8000/dashboard/profile" title="">View My
                                                Profile</a>
                                        </li>
                                    </ul>
                                </div>
                                <!--user-data end-->

                                <div class="suggestions full-width">
                                    <div class="sd-title">
                                        <h3>My Business CVs <a href="http://127.0.0.1:8000/dashboard/business">(1)</a>
                                        </h3>
                                    </div>
                                    <!--sd-title end-->
                                    <div class="sd-title new-link">
                                        <p class="text-left"><a
                                                href="http://127.0.0.1:8000/dashboard/business/verify">Add Business
                                                CV</a></p>
                                    </div>
                                    <!--sd-title end-->
                                    <div class="suggestions-list">
                                        <div class="suggestion-usd">
                                            <div class="sgt-text">
                                                <h4 data-toggle="popover" data-trigger="hover" title=""
                                                    data-content="Fitment Industries"
                                                    data-original-title="Business Profile">FITMENT INDUSTRIES</h4>
                                                <span> CITY OF ZAMBOANGA </span>

                                            </div>

                                            <span><a href="http://127.0.0.1:8000/dashboard/business/13">
                                                    <img src="http://127.0.0.1:8000/placeholder/icons/eye-inactive.png"
                                                        alt="" class="img img-responsive img-icon"
                                                        style="height: 15px; width: 30px;"></a>
                                            </span>
                                        </div>
                                        <div class="view-more">
                                            <a href="http://127.0.0.1:8000/dashboard/business" title="">[Show All]</a>
                                        </div>
                                    </div>
                                    <!--suggestions-list end-->

                                </div>
                                <!--suggestions end-->
                            </div>
                            <!--main-left-sidebar end-->
                        </div>
                        <div class="col-lg-9 col-md-8 pd-left-none ">
                            <div class="main-ws-sec">
                                <div class="post-topbar">
                                    <h4>Overview</h4>
                                    <p>Pending Transactions : <b>1</b></p>
                                    <p>Estimate Total : <b class="text-danger" style="font-size: 20px;">₱ 50.00</b></p>
                                </div>
                                <!--post-topbar end-->
                                <div class="posts-section">
                                    <p><span class="title">Recent Transactions</span>
                                    </p>
                                    <div class="post-bar">
                                        <div class="job_descp">
                                            <h3><a href="http://127.0.0.1:8000/dashboard/application/LOCALBP2011-0000014"
                                                    class="ref-transaction">LOCALBP2011-0000014 - BUSINESS PERMIT</a> <a
                                                    href="http://127.0.0.1:8000/dashboard/business/13"><b>(FITMENT
                                                        INDUSTRIES)</b></a>
                                                <span class="float-right">
                                                    <label class="badge badge-success">COMPLETED</label>
                                                </span>
                                            </h3>

                                            <table class="table table-bordered" style="width: 60%;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Transaction Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="40%">Date of Application:</td>
                                                        <td>November 05, 2020 03:01 pm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount Due:</td>
                                                        <td class="text-danger">₱ 50.00</td>
                                                    </tr>
                                                </tbody>

                                            </table>


                                            <div class="qr-holder">
                                                <img src="\/ajsd22002.png" alt="">
                                            </div>
                                        </div>

                                    </div>
                                    <!--post-bar end-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- main-section-data end-->
            </div>
        </div>
    </main>
</section>
<!--team section end-->



@stop
@section('page-styles')
<style type="text/css">
	.avatar-upload {
		position: relative;
		/*max-width: 205px;
		margin: 50px auto;*/
		width: 110px;
	    height: 110px;
	    margin-bottom: -48px !important;
	}
	.avatar-upload .avatar-edit {
		position: absolute;
	    right: 0;
	    z-index: 1;
	    top: 0;
	}
	.avatar-upload .avatar-edit input {
		display: none;
	}
	.avatar-upload .avatar-edit input + label {
		display: inline-block;
		width: 34px;
		height: 34px;
		margin-bottom: 0;
		border-radius: 100%;
		background: #FFFFFF;
		border: 1px solid transparent;
		box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
		cursor: pointer;
		font-weight: normal;
		transition: all 0.2s ease-in-out;
	}
	.avatar-upload .avatar-edit input + label:hover {
		background: #f1f1f1;
		border-color: #d6d6d6;
	}
	.avatar-upload .avatar-edit input + label:after {
		/* content: "\f304"; */
		/* font-family: 'FontAwesome'; */
		color: #757575;
	}
	.avatar-upload .avatar-preview {
		width: 110px;
		height: 110px;
		position: relative;
		border-radius: 100%;
		border: 6px solid #F8F8F8;
		box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
	}
	.avatar-upload .avatar-preview > div {
		width: 100%;
		height: 100%;
		border-radius: 100%;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
	}

	.img-cover{
		object-fit: cover;
		height: 250px;
	}
</style>
@endsection
@section('page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">

    $(".btn-submission").on('click', function(){
        var url = $(this).data('url');
        var self = $(this);

        (async () => {

        const {value: type} = await Swal.fire({
            title: 'Please choose a transaction',
            text: 'Are you applying for?',
            input: 'select',
            inputOptions: {
                'e_submission': 'E-Submissions',
                'ctc': 'Community Tax Certificate'
            },
            inputPlaceholder: 'Select Type',
            showCancelButton: true,

        })
        if (type) {
            window.location.href = url + "?type="+type;
        }
        })()

    });

    </script>
@stop
