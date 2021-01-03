<div class="modal success-modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3">
                <div class="text-center">
                    <h1 class="text-success">Success</h1>
                    <p style="font-weight: bold">We have received your Account Creation Request. Please wait for the BPLO approval. We will inform you of the updates. Thank you!</p>
                    <h6 class="text-title">Redirecting ... </h6>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.success-modal').modal('show');
        setInterval(function(){
            // '{{ session()->forget("register") }}';
            window.location.replace('{{ url()->to('/login') }}'); }, 2000);
    })
</script>
