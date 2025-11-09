<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Help - LC Happy Care Dental Clinic</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/styles.min.css?h=603e8133128ec3586bcc20713be67e15">
</head>

<body>
  <!-- Start: Sidebar With Menu -->
  @include('partials.registrant-sidebar')
  <!-- End: Sidebar With Menu -->
  
  <!-- Start: Navbar Centered Brand -->
  @include('partials.registrant-navbar')
  <!-- End: Navbar Centered Brand -->
  
  <!-- Start: FAQs -->
  <section id="faqssection" style="background: var(--bs-white);">
    <div class="container py-5">
      <div class="text-center w-75 mx-auto">
        <h1 class="text-primary mb-3">Frequently Asked Questions</h1>
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
  </section><!-- End: FAQs --><!-- Start: Footer -->
  <section class="bg-white"><!-- Start: Footer Multi Column -->
    <footer class="text-body" style="background: linear-gradient(148deg, #ffc249 15%, var(--bs-warning) 56%);">
      <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
          <div
            class="col-lg-5 col-xl-6 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-first">
            <div class="fw-bold d-flex align-items-center mb-2"><span
                class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg
                  xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
                  class="bi bi-bezier fs-5">
                  <path fill-rule="evenodd"
                    d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z">
                  </path>
                  <path
                    d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z">
                  </path>
                </svg></span><span>LC Happy Care Dental Clinic</span></div>
            <p>LC Happy Care Dental Clinic brings life to your smile through expert, gentle dental care. We create
              confident, healthy smiles with personalized treatments and a commitment to safety, compassion, and
              clinical excellence.</p>
          </div><!-- Start: Services -->
          <div class="col-sm-4 col-md-3 col-lg-2 col-xxl-2 text-center text-lg-start d-flex flex-column">
            <h3 class="fs-6 text-body">Services</h3>
            <ul class="list-unstyled">
              <li>Teeth Cleaning</li>
              <li>Dental Fillings</li>
              <li>Tooth Extraction</li>
              <li>Root Canal Theraphy</li>
              <li>Crowns &amp; Bridges</li>
              <li>Teeth Whitening</li>
            </ul>
          </div><!-- End: Services --><!-- Start: About -->
          <div class="col-sm-4 col-md-3 col-lg-2 col-xxl-2 text-center text-lg-start d-flex flex-column">
            <h3 class="fs-6 text-body">About</h3>
            <ul class="list-unstyled">
              <li><a class="link-body-emphasis" href="#">Company</a></li>
              <li><a class="link-body-emphasis" href="/aboutus.html#team">Team</a></li>
              <li><a class="link-body-emphasis" href="/aboutus.html#legacy">Legacy</a></li>
            </ul>
          </div><!-- End: About --><!-- Start: Careers -->
          <div class="col-sm-4 col-md-3 col-lg-2 col-xxl-2 text-center text-lg-start d-flex flex-column">
            <h3 class="fs-6 text-body">Careers</h3>
            <ul class="list-unstyled">
              <li><a class="link-body-emphasis" href="#">Job openings</a></li>
              <li><a class="link-body-emphasis" href="#">Employee success</a></li>
              <li><a class="link-body-emphasis" href="#">Benefits</a></li>
            </ul>
          </div><!-- End: Careers -->
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center pt-3">
          <p class="mb-0">Copyright © 2025 LC Happy Care Dental Clinic. All rights reserved.</p>
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="https://www.facebook.com/CruzDentalHub/?locale=tl_PH"
                target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                  viewBox="0 0 16 16" class="bi bi-facebook text-body">
                  <path
                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951">
                  </path>
                </svg></a></li>
            <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                  fill="currentColor" viewBox="0 0 16 16" class="bi bi-telephone-fill text-body">
                  <path fill-rule="evenodd"
                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z">
                  </path>
                </svg></a></li>
            <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                  fill="currentColor" viewBox="0 0 16 16" class="bi bi-envelope-fill text-body">
                  <path
                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z">
                  </path>
                </svg></a></li>
          </ul>
        </div>
      </div>
    </footer><!-- End: Footer Multi Column -->
  </section><!-- End: Footer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/script.min.js?h=54f9ea67a2f2b565925a52e00bfadc6c"></script>
</body>

</html>