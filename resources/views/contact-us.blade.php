@extends('layout')

@section('title', 'Contact Us - Amartha Furniture')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="contact-us">
        <div class="container">
            <div class="title">
                <p>Lorem ipsum dolor sit amet,</p>
                <h1><b>Contact us now</b></h1>
            </div>

            <!-- Menampilkan peta Durenworks di Google Map -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.524742004157!2d110.44461331427722!3d-7.064989671202162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708ea83406925d%3A0x6229331c0c57e3d6!2sDurenworks!5e0!3m2!1sen!2sid!4v1444393540736" width="100%" height="350" frameborder="0" style="border:0"></iframe>

            <div class="row">
                <div class="col-sm-6" style="padding-left: 0px;">
                    <div class="col-sm-12 col-xs-12 contact-info">
                        <h2><b>Contact Info</b></h2>
                        <p>Our customer is our priority. Part of Amartha’s business philosophy is to deliver great customer service experience. Submit your enquiries or designs here and our customer service representative will contact you soon.</p>
                    </div>

                    <div class="col-sm-12 col-xs-6 address">
                        <h2><b>Address:</b></h2>
                        <p>
                            795 Fake Ave, Door 6<br/>
                            Wonderland, CA 94107, USA
                        </p>
                    </div>

                    <div class="col-sm-12 col-xs-6 phone-fax">
                        <h2><b>Phone:</b></h2>
                        <p>
                            <a href="tel:">+440 875369208</a><br/>
                            <a href="tel:">+440 353363114</a>
                        </p>
                    </div>

                    <div class="col-sm-12 col-xs-6 email">
                        <h2><b>Email:</b></h2>
                        <p>
                            <a href="mailto:">info@Loremipsum.com</a><br/>
                            <a href="mailto:">support@Loremipsum.com</a>
                        </p>
                    </div>
                <div class="clear"></div>
                </div>

                <div id="contact-form" class="col-sm-6">
                    <form action="{{ action('CompanyInfoController@contactUs') }}" method="post">
                        <h2><b>Get in Touch</b></h2>
                        @if(session('success') != null)
                            <p class="bg-success"><b>{{ session('success') }}</b></p>
                        @endif
                        @if(session('error') != null)
                            <p class="bg-danger"><b>{{ session('error') }}</b></p>
                        @endif
                        <div class="form-group">
                            <label class="sr-only" for="contact-us-name">Your Name...</label>
                            <input id="contact-us-name" type="text" class="form-control" name="name" placeholder="Your Name..." value="{{ old('name') }}">
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="contact-us-email">Your Email...</label>
                            <input id="contact-us-email" type="text" class="form-control" name="email" placeholder="Your Email Address..." value="{{ old('email') }}">
                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="contact-us-message">Your Message...</label>
                            <textarea id="contact-us-message" name="message" class="form-control" rows="10" placeholder="Your Message..."></textarea>
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{ Config::get('recaptcha.site_key') }}"></div>
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-default hover">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
@stop