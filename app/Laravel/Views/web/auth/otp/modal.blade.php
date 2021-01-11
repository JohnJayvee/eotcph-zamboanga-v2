<style>
    .otp-btn {
        background-color: #1581f0;
        border: none;
        border-radius: 5px;
        color: white;
        padding: 5px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>

<div class="modal otp-modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <h3 class="text-form text-title">ENTER ONE-TIME PASSWORD</h3>
            <!-- <p>An OTP was sent to your <b>EMAIL</b>. This is valid for <b>5 minutes</b></p> -->
            <div class="text-center pt-2 pb-2">
                @error('otp_code')
                    <p><span class="text-danger"><b>{{ $message }}</b></span></p>
                @enderror
                <form method="POST" action="{{ route('web.register.otp_submit') }}">
                    @csrf
                    <div class="digit-group">
                        <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                        <input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                        <input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                        <input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                        <input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                        <input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />
                        <input type="hidden" name="code" />
                        <p class="text-muted text-form p-3">Did not recieved OTP?</p>
                    </div>
                    <a href="{{ route('web.register.otp') }}">Resend OTP via <b>EMAIL</b></a>
                    <div class="row pt-5">
                        <div class="col-md-12">
                            <button type="submit" class="otp-btn m-2 submitOTP">Submit</button>
                            <!-- <a href="#" class="otp-btn m-2" data-dismiss="modal">Close</a> -->
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
    // $('.submitOTP').click(function (){
    //     $('.otp-modal').modal('hide');
    //     $('.success-modal').modal('show');
    // })
</script>
