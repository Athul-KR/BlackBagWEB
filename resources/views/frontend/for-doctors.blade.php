@extends('frontend.master_website')
@section('title', 'For Doctors')
@section('content')

<section class="banner-container doctors-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="content_box">
                    <p class="primary">Join Our Doctors Community</p>
                    <h1>Connect, Grow, and Thrive with Us</h1>
                    <p>Our community of doctors offers you the opportunity to expand your practice by connecting with patients online. Join us today to provide exceptional care from anywhere, access cutting-edge resources, and contribute to a supportive network that values collaboration and continuous improvement.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="image-container text-center mt-lg-0 mt-3">
                    <img src="{{asset('frontend/images/find_doc_banner.webp')}}" class="img-fluid doc-banner" alt="Community">
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row h-100">
            <div class="col-lg-6 col-12">
                <div class="content_box pe-xl-5 mb-4">
                    <h3>Connect with Patients Anytime, Anywhere</h3>
                </div>

            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box mb-4">
                    <p>BlackBlag enables you to extend your practice beyond traditional settings, offering convenient and efficient care while accessing valuable resources and support.</p>
                </div>

            </div>
            <div class="col-lg-4 col-12 mb-lg-0 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img class="card-img-top mb-3" src="{{asset('frontend/images/card1.png')}}" alt="Card image cap">
                        <h2 class="card-title">Streamlined Patient Management</h2>
                        <p class="card-text">Enjoy integrated features that allow for easy tracking of patient history and treatment plans.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mb-lg-0 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img class="card-img-top mb-3" src="{{asset('frontend/images/card2.png')}}" alt="Card image cap">
                        <h2 class="card-title">Increased Patient Engagement</h2>
                        <p class="card-text">Enhanced engagement helps build stronger patient relationships and improves overall patient satisfaction.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <img class="card-img-top mb-3" src="{{asset('frontend/images/card3.png')}}" alt="Card image cap">
                        <h2 class="card-title">Expand Your Patient Reach</h2>
                        <p class="card-text">Offer your expertise to a wider audience and attract patients who may not have had access to your services otherwise.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>



<section>
    <div class="container">
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p>Seamless Virtual Consultations</p>
                    <h3 class="pe-3">Healthcare at Your Convenience</h3>
                    <p class="my-3">BlackBlag allows you to conduct virtual consultations effortlessly, giving you the flexibility to connect with patients from any location. Patients benefit from the convenience and accessibility of receiving care from the comfort of their homes, while you manage your practice more efficiently.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="{{asset('frontend/images/health_convice.webp')}}" class="img-fluid" alt="Virtual Consultations">
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12">
                <div class="image-container pe-lg-4">
                    <img src="{{asset('frontend/images/flexible.webp')}}" class="img-fluid" alt="Flexibility">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box">
                    <p>Work From Anywhere</p>
                    <h3 class="pe-3">Greater Flexibility in Your Practice</h3>
                    <p class="my-3">Enjoy unparalleled flexibility in managing your practice. Conduct appointments and follow-ups online, you can work from any location and adapt your schedule to fit your personal and professional needs. Balance your workload, reduce overhead costs, and maintain a healthy work-life balance, all while continuing to provide high-quality patient care.</p>
                    <a class="btn btn-primary" href="{{url('getstarted')}}">Get Started</a>
                </div>
            </div>
        </div>

    </div>
</section>

<section>
    <div class="container">
        <div class="info_wrapper doctor-info position-relative overflow-hidden">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="content_box">
                        <p>Empower Your Virtual Practice</p>
                        <h3>Cutting-Edge Tools and Resources</h3>
                        <p class="my-3">Access a suite of advanced tools and resources designed to support and enhance your virtual practice. By utilizing these innovative resources, you can offer a seamless and modern healthcare experience that meets the evolving needs of your patients.</p>
                        <a class="btn btn-outline-primary" href="{{url('getstarted')}}">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="image-container position-absolute bottom-0 end-0">
                        <img src="{{asset('frontend/images/find_resource.webp ')}}" class="img-fluid box-side-img" alt="Virtual Practice">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection()