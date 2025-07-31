<?php $Corefunctions = new \App\customclasses\Corefunctions; ?>
@if(!empty($invoices))
    <div class="row listing pt-3">
        <div class="col-12">
            <h4 class="setting-hd mb-2">Billing and Invoicing</h4>
            <p>Manage billing information and view receipt</p>
        </div>
        <div class="col-12">
            <section class="billing-list">
                <table class="table table-bordered  table-responsive-stack" id="tableOne">
                    <thead class="thead-dark">
                        <tr>
                            <th style="flex-basis: 20%;">Invoice Number</th>
                            <th style="flex-basis: 15%;">Billing Date</th>
                            <th style="flex-basis: 15%;">Subscription Plan</th>
                            <th style="flex-basis: 15%;">Amount</th>
                            <th class="text-end" style="flex-basis: 30%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $inv)
                            <tr>
                                <td>
                                    <div class="owner-img">
                                        <img class="me-2" src="{{ asset('/img/pdf.png') }}">
                                        <p class="m-0">{{ $inv['invoice_number'] }}</p>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $date = (isset($inv['billing_date']) && ($inv['billing_date'] != "")) 
                                            ? $Corefunctions->timezoneChange($inv['billing_date'], "d M Y") 
                                            : ""; 
                                    ?>
                                    <span>{{ $date }}</span>
                                </td>
                                <td>
                                    <span>
                                        {{ $inv['plan_name'] }}
                                    </span>  
                                </td> 
                                <td class="d-flex align-items-center justify-content-between" style="flex-basis: 15%;">
                                    <span>{{$inv['amount_label']}} </span>
                                </td>
                                <td class="text-end invoice-btns">
                                    @if ($inv['status'] == 2 && isset($inv['payment_id']) && ($inv['payment_id'] != '0'))
                                        <a onclick="viewReciept('{{ $inv['payment_id'] }}')" class="btn receipt-btn">View Receipt</a>
                                    @endif
                                    @if ($inv['status'] == '1')
                                        <a onclick="payInvoice('{{ $inv['invoice_uuid'] }}')" class="btn invoice-btn">Pay Now</a>
                                    @endif 
                                    <a onclick="viewInvoice('{{ $inv['invoice_uuid'] }}')" class="btn invoice-btn">View Invoice</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endif

<div class="modal login-modal payment-success fade" id="viewinvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">View Invoice</h5>
                </div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0" id="invoicepdf">
                <div class="preloaderappend inquirylistloder centered notification-loader"><img src="{{ asset('img/loading.gif') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal payment-success fade" id="viewreceipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">View Receipt</h5>
                </div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0" id="receiptpdf">
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal payment-success fade" id="payinvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">Pay Invoice</h5>
                </div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0 invoice-success" id="invoicepayment">
            </div>
        </div>
    </div>
</div>

<script>
    function viewInvoice(pkey) {
        $("#viewinvoice").modal('show');
        $("#invoicepdf").html('<div class="preloaderappend inquirylistloder  notification-loader billing_loader"><img src="{{ asset('img/loading.gif') }}"></div><iframe id="invoice_iframe"  width="100%" height="600"></iframe>');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/subscriptions/viewinvoice')}}",
            data:{ 
                'key': pkey,
                "_token": "{{ csrf_token() }}"
            },
            dataType : 'json',
            success: function(data) {
                if(data.success==1){ 
                    $('#invoice_iframe').attr('src', data.invoicePath);
                    $('#invoice_iframe').on('load', function() {
                        $(".preloaderappend").hide();
                    });
                }
            }
        });
    }

    function viewReciept(pkey) {
        $("#receiptpdf").html('<div class="preloaderappend inquirylistloder  notification-loader billing_loader"><img src="{{ asset('img/loading.gif') }}"></div><iframe id="receipt_iframe"  width="100%" height="600"></iframe>');
        $("#viewreceipt").modal('show');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/subscriptions/viewreceipt')}}",
            data:{ 
                'key': pkey,
                "_token": "{{ csrf_token() }}"
            },
            dataType : 'json',
            success: function(data) {
                if(data.success==1){
            
                    $('#receipt_iframe').attr('src', data.invoicePath);
                    $('#receipt_iframe').on('load', function() {
                        $(".preloaderappend").hide();
                    });
                }
            }
        });
    }
    function payInvoice(invkey){
        showPreloader('invoicepayment');
        $("#invoicepayment").html('<div class="preloaderappend inquirylistloder  notification-loader billing_loader"><img src="{{ asset('img/loading.gif') }}"></div><iframe id="pay_invoice_iframe"  width="100%" height="600"></iframe>');
        $("#payinvoice").modal('show');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/subscriptions/payinvoice')}}",
            data:{ 
                'invoicekey': invkey,
                "_token": "{{ csrf_token() }}"
            },
            dataType : 'json',
            success: function(data) {
            if(data.success == '1'){
                $('#pay_invoice_iframe').attr('src', data.action_url);
                $('#pay_invoice_iframe').on('load', function() {
                    $(".preloaderappend").hide();
                });
            }else{
                $("#payinvoice").modal('hide');
                swal('Oops! Your invoice has been expired. Please purchase a new Subscription.', '', 'error');
                window.location.reload();
            }
            }
        });
    }
    function paymentCompleted(){
        console.log('payment completed');
        window.location.href = '{{url("subscriptions")}}';
    }
</script>