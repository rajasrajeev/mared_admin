@extends('layouts.frontend')
@section('content')
<div class="page">
@include('components.home_made_by_builder.header2')
<!-- Swiper default-->
<section class="swiper-container swiper-1 context-dark text-center" data-swiper='{"autoplay":false}'>
        <!-- Additional required wrapper-->
        <div class="swiper-wrapper">
          <!-- Slides-->
          <div class="swiper-slide section-md" style="background-image: url('{{ asset(get_frontend_settings('banner_image')) }}')"
          >
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-9 col-lg-7">
                  <h1>Inspiration, Innovation and Discovery</h1>
                  <p class="big">Any successful career starts with good education. Together with us you will have deeper knowledge of the subjects that will be especially useful for you when climbing the career ladder.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide section-md" style="background-image: url('{{ asset(get_frontend_settings('banner_image2')) }}')"
>
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-9 col-lg-7">
                  <h1>Investing in Knowledge and Your Future</h1>
                  <p class="big">At Mared Education, you can succeed in lots of research areas and benefit from investing in your education and knowledge that will help you in becoming an experienced specialist.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide section-md" style="background-image: url('{{ asset(get_frontend_settings('banner_image3')) }}')"
          >
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-9 col-lg-7">
                  <h1>Open Minds Aimed at Creating Future</h1>
                  <p class="big">Build your future with us! The educational programs of our University will give you necessary skills, training, and knowledge to make everything you learned here work for you in the future.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Pagination-->
        <div class="swiper-pagination"></div>
      </section>
      <!-- Blurb default-->
      <section class="section-md bg-transparent text-center">
        <div class="container">
          <div class="text-block text-block-1" data-animate='{"class":"fadeIn"}'>
            <h5 class="text-primary">Guaranteed Success</h5>
            <h2>What We Offer</h2>
            <p class="big">Mared Education offers students the best of education and entertainment opportunities available in the area. We are glad to take care of every student and university entrant.</p>
          </div>
          <div class="row row-30 justify-content-center">
            <div class="col-sm-6 col-md-4">
                    <!-- Blurb-->
                    <article class="blurb blurb-2" data-animate='{"class":"fadeInUp"}'>
                      <div class="icon blurb-icon custom-font-online-course"></div>
                      <div class="blurb-title h4">Online Education</div>
                      <div class="blurb-text big">Mared Education provides online education services with all learning materials and lectures available to you.</div>
                    </article>
            </div>
            <div class="col-sm-6 col-md-4">
                    <!-- Blurb-->
                    <article class="blurb blurb-2" data-animate='{"class":"fadeInUp","delay":".15s"}'>
                      <div class="icon blurb-icon custom-font-degree"></div>
                      <div class="blurb-title h4">Programs &amp; Courses</div>
                      <div class="blurb-text big">We offer a wide range of courses and  programs that encompass lots of knowledge spheres.</div>
                    </article>
            </div>
          </div>
        </div>
      </section>
      <!-- Price box-->
    <section class="section-md bg-300 text-center">
    <div class="container">
        <div class="text-block text-block-1" data-animate='{"class":"fadeIn"}'>
        <h2>Our Classes</h2>
        <p class="big">Our featured classes are selected through a rigorous process and uniquely created for each semester. They cover a lot of topics and are available both online and offline.</p>
        </div>
        <div class="owl-carousel owl-content-1" data-owl="{&quot;dots&quot;:true}" data-loop="false" data-items="1" data-sm-items="2" data-md-items="3" data-lg-items="4">
        @foreach (App\Models\Category::where('parent_id', 0)->take(32)->get() as $category)
            <div class="price-box">
            <div class="price-box-media">
                <a href="{{ route('courses', ['category' => $category->slug]) }}">
                <img class="price-box-img" src="{{ get_image($category->category_logo) }}" alt="{{ $category->title }}" width="270" height="220"/>
                </a>
            </div>
            <div class="price-box-body">
                <div class="price-box-title h6">
                <a href="{{ route('courses', ['category' => $category->slug]) }}">{{ $category->title }}</a>
                </div>
            </div>
            </div>
        @endforeach
        </div>
    </div>
    </section>
      <!-- Person side-->
      <section class="section-md bg-transparent text-center">
        <div class="container">
          <div class="text-block text-block-1" data-animate='{"class":"fadeIn"}'>
            <h5 class="text-primary">People Behind Our Success</h5>
            <h2>Our Tutors</h2>
            <p class="big">We employ highly experienced and qualified teachers who set the ground for all our programs and courses. They are aimed to help you achieve more on your path to success.</p>
          </div>
          <div class="row row-30 row-lg-60">
            @foreach ($teachers as $teacher)
            <div class="col-xs-6 col-lg-4">
                    <!-- Person side-->
                    <div class="person person-side" data-animate='{"class":"fadeInUp"}'>
                      <div class="person-media"><img class="person-img" src="{{get_image($teacher['photo']) }}}}" alt="" width="135" height="135"/>
                      </div>
                      <div class="person-body">
                        <div class="person-title h6"><a href="#">{{$teacher['name']}}</a></div>
                        <div class="person-meta">Teacher</div>
                        <!-- <div class="person-text">Leslie joined our team in 2010 as a marketing tutor.</div> -->
                        <!-- <div class="person-social social"><a class="icon social-icon custom-font-facebook" href="#"></a><a class="icon social-icon custom-font-twitter" href="#"></a><a class="icon social-icon custom-font-linkedin" href="#"></a> -->
                        </div>
                      </div>
                    </div>
            </div>
            @endforeach


          </div>
        </div>
      </section>
      <!-- Counters-->
      <section class="section-lg bg-primary bg-image-wrap context-dark text-center text-md-start">
        <div class="bg-image-wrap-item bg-image" style="background-image:url('{{asset('assets/frontend/new/images/image-05-875x705.jpg')}}');"></div>
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <div class="pe-xxl-5">
                <h2>Why Choose Us</h2>
                <p class="big">Mared Education offers quality education helping you build your future career. Here just some of the facts that show why students choose us.</p>
                <div class="row row-30 row-lg-55">
                  <div class="col-6 col-sm-3 col-md-6">
                          <!-- Blurb side-->
                          <article class="blurb blurb-side">
                            <div class="blurb-item">
                              <div class="icon blurb-icon custom-font-graduated"></div>
                            </div>
                            <div class="blurb-body">
                              <div class="blurb-counter-value h2"><span data-counter="">97</span><span class="counter-postfix">%</span>
                              </div>
                              <div class="blurb-title h4">Graduates</div>
                            </div>
                          </article>
                  </div>
                  <div class="col-6 col-sm-3 col-md-6">
                          <!-- Blurb side-->
                          <article class="blurb blurb-side">
                            <div class="blurb-item">
                              <div class="icon blurb-icon custom-font-male-teacher"></div>
                            </div>
                            <div class="blurb-body">
                              <div class="blurb-counter-value h2"><span data-counter="">50</span><span class="counter-postfix">+</span>
                              </div>
                              <div class="blurb-title h4">Certified tutors</div>
                            </div>
                          </article>
                  </div>
                  <div class="col-6 col-sm-3 col-md-6">
                          <!-- Blurb side-->
                          <article class="blurb blurb-side">
                            <div class="blurb-item">
                              <div class="icon blurb-icon custom-font-student-at-desk"></div>
                            </div>
                            <div class="blurb-body">
                              <div class="blurb-counter-value h2"><span data-counter="">6500</span>
                              </div>
                              <div class="blurb-title h4">Students</div>
                            </div>
                          </article>
                  </div>
                  <div class="col-6 col-sm-3 col-md-6">
                          <!-- Blurb side-->
                          <article class="blurb blurb-side">
                            <div class="blurb-item">
                              <div class="icon blurb-icon custom-font-university"></div>
                            </div>
                            <div class="blurb-body">
                              <div class="blurb-counter-value h2"><span data-counter="">10</span>
                              </div>
                              <div class="blurb-title h4">Campuses</div>
                            </div>
                          </article>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @include('components.home_made_by_builder.footer2')
</div>
@endsection
