{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<footer class="section footer">
        <div class="footer-top bg-300">
          <div class="container">
            <div class="row row-30">
              <div class="col-xs-6 col-md-3">
                <h5 class="footer-title">Contacts</h5>
                <ul class="list list-icons">
                  <li class="list-item">
                    <div class="list-icon custom-font-pin"></div><a class="link link-inherit" href="#">>{{ get_settings('address') }}</a>
                  </li>
                  <li class="list-item">
                    <div class="list-icon custom-font-email"></div><a class="link link-inherit" href="mailto:#">{{ get_settings('system_email') }}</a>
                  </li>
                  <li class="list-item">
                    <div class="list-icon custom-font-phone"></div><span><span>{{ get_phrase('Phone : ') }}: </span><a class="link link-inherit" href="tel:#">
                    {{ get_settings('phone') }}</a></span>
                  </li>
                </ul>
              </div>
              <div class="col-6 col-md-3">
                <h5 class="footer-title">Socials</h5>
                <ul class="list list-sm">
                  <li class="list-item"><a class="link link-inherit" href="{{ get_frontend_settings('facebook') }}">Facebook</a></li>
                  <!-- <li class="list-item"><a class="link link-inherit" href="#">Pinterest</a></li> -->
                  <li class="list-item"><a class="link link-inherit" href="{{ get_frontend_settings('linkedin') }}">LinkedIn</a></li>
                  <!-- <li class="list-item"><a class="link link-inherit" href="#">Instagram</a></li> -->
                  <li class="list-item"><a class="link link-inherit" href="{{ get_frontend_settings('twitter') }}">Twitter</a></li>
                  <!-- <li class="list-item"><a class="link link-inherit" href="#">YouTube</a></li> -->
                </ul>
              </div>
              <div class="col-6 col-md-3">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="list list-sm">
                  <li class="list-item"><a class="link link-inherit" href="/login">Supervisor Login</a></li>
                  <li class="list-item"><a class="link link-inherit" href="/login">Agent Login</a></li>
                  <li class="list-item"><a class="link link-inherit" href="/login">Team Leader Login</a></li>
                  <li class="list-item"><a class="link link-inherit" href="/login">Student Login</a></li>
                </ul>
              </div>
              <div class="col-6 col-md-3">
                <h5 class="footer-title">Student Registration</h5>
                <ul class="list list-sm">
                 <a class="btn btn-primary" href="/register">Apply Now</a>
                </ul>
              </div>

            </div>
          </div>
        </div>
        <div class="footer-bottom bg-700 context-dark text-center">
          <div class="container">
                  <!-- Copyright-->
                  <p class="rights"><span>&copy; 2021&nbsp;</span><span>Teachzy</span><span>. All rights reserved.&nbsp;</span><a class="link link-inherit" href="privacy-policy.html">Privacy Policy</a></p>
          </div>
        </div>
      </footer>
