@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row align-items-start">
                <div class="col-8 mb-3">
                  <h4 class="mb-0">Support</h4>
                </div>
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-xl-6 col-12 mx-auto">
                      <div class="text-center">
                        <img alt="Blackbag" src="{{ asset('images/active_support.jpg') }}" class="img-fluid supportImg mb-4">
                        <h3 class="fw-medium">Get the Help You Need</h3>
                        <h6 class="gray">We're Here to Assist You with Any Questions or Issues</h6>
                      </div>
                    </div>
                    <div class="col-xl-6 col-12">
                      <div class="row">
                      <div class="col-lg-10 col-xl-9 mx-auto text-center">
                      <h4 class="mb-3">Send us a message and we will <br>help you sort things out</h4>
                        <form method="post" action="{{ route('support.store') }}" id="support_form" autocomplete="off">
                          @csrf
                          <div class="form-group form-floating mb-4 mb-4">
                            <i class="material-symbols-outlined">contact_support</i>
                            <select name="support_type" class="form-select">
                              <option value="">Select Issue Type</option>
                              @foreach ($supportTypes as $supportType)
                              <option value="{{ $supportType->id }}">{{ $supportType->type }}</option>
                              @endforeach
                            </select>
                            <label class="select-label">Tell us about your technical issue</label>
                          </div>
                          <div class="form-group form-outline form-textarea mb-4">
                            <label for="input" class="float-label">Message</label>
                            <i class="fa-solid fa-file-lines"></i>
                            <textarea name="message" class="form-control" rows="4" cols="4"></textarea>
                          </div>
                          <div class="btn_alignbox">
                            <button type="submit" id="support_form_btn" class="btn btn-primary w-100">Submit Your Feedback</button>
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    var form = $("#support_form");

    $("#support_form").validate({
      rules: {
        support_type: {
          required: true
        },
        message: {
          required: true,
        }
      },
      messages: {
        support_type: {
          required: "Please select a support type"
        },
        message: {
          required: "Please enter message.",
          minlength: "Your message must be at least 10 characters long"
        }
      },
      submitHandler: function(form) {
        $('#support_form_btn').prop('disabled', true);
        $('#support_form_btn').text("Submitting.....");
        form.submit();
      }
    });
  });

 

  
</script>
@stop