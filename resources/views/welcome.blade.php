<!DOCTYPE html>
<html data-bs-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>LC Happy Care Dental Clinic - Your Trusted Dental Partner</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>

<body style="background: var(--bs-primary-bg-subtle);"><!-- Start: Navbar Centered Links -->
@include('partials.home-navbar')

  <!-- Start: Hero Overlay -->
  <section class="text-white mt-0 pt-0 py-xl-5" data-aos="fade"
    style="background: linear-gradient(rgba(0,0,0,0.2), rgba(8,25,44,0.61) 67%), linear-gradient(rgba(200,150,0,0.57), rgba(203,153,25,0.6) 100%), url('{{ asset('assets/img/1753427791969.jpg') }}') center / cover no-repeat;">
    <div class="container">
      <div
        class="border rounded border-0 d-flex flex-column justify-content-center align-items-center p-4 me-0 mt-0 py-5"
        style="height: 500px;">
        <div class="row">
          <div
            class="col-md-10 col-xl-8 text-center d-flex d-sm-flex d-md-flex justify-content-center align-items-center justify-content-md-start align-items-md-center justify-content-xl-center mx-auto">
            <div class="mb-3">
              <h1 class="text-uppercase fw-bold mb-3">Welcome to LC Happy Care Clinic!</h1>
              <p class="mb-4">Your smile is our priority. Book your appointment now and experience happy, caring dental
                services with our professional team!</p>
              <div class="row">
                <div
                  class="col d-flex flex-column flex-shrink-1 justify-content-center align-items-center flex-sm-row ps-sm-0 me-sm-0 pe-sm-0">
                  <a class="btn btn-outline-light fs-5 me-0 mx-2 px-4 my-2 py-2 col-auto" role="button" href="{{ route('home.process') }}">How does
                    this work?</a>
                    <a class="btn btn-primary fs-5 me-0 mx-2 px-4 py-2 col-auto" role="button"
                    href="{{ route('login') }}">Book an Appointment</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col" style="text-align: center;">
          <p class="mb-0 pb-2">Located at&nbsp; Sampaguita St., Bagumbayan, Roxas, Oriental Mindoro, Philippines</p>
          <p>Clinic Schedule: Monday to Sunday: 8:00 AM - 5:00 PM</p>
        </div>
      </div>
    </div>
  </section><!-- End: Hero Overlay --><!-- Start: Services Showcase -->
  <section style="background: linear-gradient(#daa400 0%, var(--bs-dark) 80%), var(--bs-dark);">
    <!-- Start: Features Small Icons Color -->
    <div class="container text-white border rounded border-0 p-4 p-lg-5 py-4 py-xl-5">
      <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <h2 class="text-white">Our Services</h2>
          <p>Here in LC Happy Care Dental Clinic, your smile is our mission! With our wide range of services, we ensure
            that your smile will always be whole.</p>
        </div>
      </div>
      <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Teeth Cleaning</h4>
              <p>Professional cleaning to remove plaque, tartar, and stains, keeping your teeth healthy and your smile bright. Regular cleanings prevent cavities and gum disease.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Dental Fillings</h4>
              <p>Restore damaged or decayed teeth with durable fillings that match your natural tooth color. We help preserve your tooth structure and prevent further decay.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Tooth Extraction</h4>
              <p>Safe and comfortable tooth removal when necessary. Our experienced team ensures minimal discomfort and proper care for optimal healing and recovery.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Root Canal Therapy</h4>
              <p>Save infected or damaged teeth with advanced root canal treatment. We relieve pain and restore your tooth's health while preserving your natural smile.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Crowns &amp; Bridges</h4>
              <p>Restore missing or damaged teeth with custom-fitted crowns and bridges. Improve both function and appearance for a complete, confident smile.</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="d-flex">
            <div
              class="bs-icon-md bs-icon-circle bs-icon-semi-white text-primary d-flex flex-shrink-0 justify-content-center align-items-center mb-3 d-inline-block bs-icon">
              <i class="fas fa-tooth fs-5 text-dark"></i></div>
            <div class="px-3">
              <h4 class="text-white">Teeth Whitening</h4>
              <p>Brighten your smile with professional whitening treatments. Safe and effective solutions to remove stains and discoloration for a radiant, youthful appearance.</p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End: Features Small Icons Color --><!-- Start: Contact Map Two Columns -->
    <section class="bg-body position-relative py-4 py-xl-5">
      <div class="container position-relative">
        <div class="row">
          <div class="col"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3088.960685037598!2d121.51691593509636!3d12.588175746717758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bb49e045bd0a2b%3A0x1a7a01998152e649!2sLC%20Happy%20Care%20Dental%20Clinic!5e0!3m2!1sfil!2sph!4v1759843343086!5m2!1sfil!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
          <div class="col-md-6 col-xl-4">     
            <div>
              <form class="p-3 p-xl-4" method="post" action="{{ route('contact.submit') }}">
                @csrf
                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <h3 style="color: var(--bs-dark);">Contact us</h3>
                <p class="text-black-50 ps-0"><a class="me-sm-2" href="tel:+639451996006"><svg xmlns="http://www.w3.org/2000/svg"
                      width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-telephone-fill me-2"
                      style="--bs-body-color: var(--bs-white);color: var(--bs-dark);">
                      <path fill-rule="evenodd"
                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                      </path>
                    </svg></a>09451996006 or 09292297847<br><a class="me-sm-2" href="mailto:leddieczarinaapara@gmail.com"><svg
                      xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                      viewBox="0 0 16 16" class="bi bi-envelope-fill me-2"
                      style="--bs-body-color: var(--bs-white);color: var(--bs-dark);">
                      <path
                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z">
                      </path>
                    </svg></a>Email us at leddieczarinaapara@gmail.com<br><a class="me-sm-2" href="#"><svg
                      xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                      viewBox="0 0 16 16" class="bi bi-clock-fill me-2"
                      style="--bs-body-color: var(--bs-white);color: var(--bs-dark);">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z">
                      </path>
                    </svg></a>Monday to Sunday: 8:00 AM - 5:00 PM</p><!-- Start: Success Example -->
                <div class="mb-3">
                  <label class="form-label" for="name" style="color: var(--bs-dark);">Name *</label>
                  <input
                    class="form-control" type="text" id="name" name="name" required
                    value="{{ old('name') }}" style="background: var(--bs-dark-bg-subtle);">
                  </div>
                <!-- End: Success Example --><!-- Start: Error Example -->
                <div class="mb-3">
                  <label class="form-label" for="email"
                    style="color: var(--bs-dark);">Email *</label>
                  <input class="form-control" type="email" id="email"
                    name="email" required value="{{ old('email') }}" style="background: var(--bs-dark-bg-subtle);">
                </div><!-- End: Error Example -->
                <div class="mb-3">
                  <label class="form-label" for="message"
                    style="color: var(--bs-dark);">Message *</label>
                  <textarea class="form-control" id="message"
                    name="message" rows="6" required style="background: var(--bs-dark-bg-subtle);">{{ old('message') }}</textarea>
                </div>
                <div class="mb-3"><button class="btn btn-primary" type="submit">Send Message</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End: Contact Map Two Columns -->
  </section><!-- End: Services Showcase --><!-- Start: Banner Clean -->
  <section class="py-4 py-xl-5" style="background: #c59203;">
    <div class="container">
      <div class="text-center p-4 p-lg-5">
        <p class="fw-bold text-white mb-2">LC HAPPY CARE DENTAL CLINIC</p>
        <h1 class="fw-bold mb-4">Let's give your smile the attention it deserves—book your consultation today!</h1>
        <a class="btn btn-light fs-6 me-2 mt-2 px-4 py-2" role="button" href="{{ route('home.services') }}">Dental Services Overview</a>
        <a class="btn btn-primary fs-6 mt-2 px-4 py-2" role="button" href="{{ route('login') }}">Book an Appointment</a>
      </div>
    </div>
  </section><!-- End: Banner Clean --><!-- Start: FAQs -->
  <section id="faqssection" style="background: var(--bs-white);">
    <div class="container py-5">
      <div class="text-center w-75 mx-auto">
        <h1 class="text-dark mb-3">Frequently Asked Questions</h1>
        <p>Here are some of the answers to frequently asked questions</p>
        <div class="justify-content-center row">
          <div class="col-lg-12 col-xl-8">
            <div class="accordion" role="tablist" id="accordion-1">
              <div class="accordion-item">
                <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-1" aria-expanded="false"
                    aria-controls="accordion-1 .item-1">How to start an appointment?</button></h2>
                <div class="accordion-collapse collapse item-1" role="tabpanel" data-bs-parent="#accordion-1">
                  <div class="accordion-body">
                    <p class="mb-0" style="text-align: left;">To start an appointment, create first an account in this
                      website. Afterwards, you can now select a service and choose the convenient date and time for your
                      schedule.</p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-2" aria-expanded="false"
                    aria-controls="accordion-1 .item-2">How to settle payment?</button></h2>
                <div class="accordion-collapse collapse item-2" role="tabpanel" data-bs-parent="#accordion-1">
                  <div class="accordion-body">
                    <p class="mb-0" style="text-align: left;">Payment transactions are only limited to face-to-face. We
                      cannot accommodate online payment mode.</p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-3" aria-expanded="false"
                    aria-controls="accordion-1 .item-3">Can I apply for multiple services?</button></h2>
                <div class="accordion-collapse collapse item-3" role="tabpanel" data-bs-parent="#accordion-1">
                  <div class="accordion-body acco">
                    <p class="mb-0" style="text-align: left;">Our customers can freely schedule multiple services in a
                      single appointment.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End: FAQs -->
  <!-- Start: Footer -->
    @include('partials.home-footer')
  <!-- End: Footer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
</body>

</html>