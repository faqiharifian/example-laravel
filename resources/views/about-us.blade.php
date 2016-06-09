@extends('layout')

@section('title', 'About - Amartha Furniture')

@section('content')
    <div class="about">
        <div class="container">
            <div class="title">
                <p>Timeless Furniture for the Modern People</p>
                <h1><b>About Amartha Furniture</b></h1>
            </div>
            <div class="backdrop-wrapper">
                <img src="/{{ Config::get('path.images') }}/about/backdrop.png" alt="">
            </div>

            <div class="row description">
                <p>
                    Amartha furniture is a furniture company located at Jepara, the home to various furniture manufacturers in Indonesia. The company is a part of Cv. Jatindo Ukir Jepara and is managed by CEO Sutrimo Yusuf. With more than 20 years of hands on experience, Amartha is one of the top 5 furniture company in Jepara.
                </p>
                <p>
                    Our furniture company employs more than 100 staff members and occupies 3550 square meters of land to facilitate our operations. With our state-of-the-art manufacturing facilities and conducive offices; our staffs were able to plan, produce and export high quality furniture to many countries. We took our time to carefully assemble our furniture to ensure that they meet the highest quality standards so it stands the test of time.
                </p>
                <p>
                    Amartha furniture specializes in designing classic-traditional furniture that has become very rare nowadays. Traditional furniture takes inspiration from a variety of eras, often from the 18th or 19th centuries. In a world filled with simple contemporary designs; timeless elegant furniture is just what you need to make your room stand out. Our company produces garden as well as indoor furniture made of teak and mahogany wood.  
                </p>
                <p>
                    Go to our contact page if you have any further enquiries.
                </p>

                <hr/>

            </div>
        </div>

        <div class="why-are-we">
            <div class="container">
                <div class="row">
                    <div class="title">
                        <h2><b>Why Choose Amartha</b></h2>
                        <p>Elegant design meets quality materials and experience…</p>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <img src="/{{ Config::get('path.images') }}/about/experts-to-the-furniture.png" alt="" class="pull-right">
                            <h3 class="vertical-center"><b>Unique Custom Designs</b></h3>
                        </div>
                        <hr>
                        <p>Amartha furniture specializes in custom woodworking services. Our commitment to quality and great customer service experience made our custom woodworking services one of our most popular services.</p>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <img src="/{{ Config::get('path.images') }}/about/our-experience.png" alt="" class="pull-right">
                            <h3 class="vertical-center"><b>Real Hands on Experience</b></h3>
                        </div>
                        <hr>
                        <p>Amartha furniture has been running for more than 20 years. Our products have been exported to Belgium, Singapore, Turkey, Bahrain, United States, Qatar and Russia.</p>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <img src="/{{ Config::get('path.images') }}/about/quality-of-materials.png" alt="" class="pull-right">
                            <h3 class="vertical-center"><b>Quality of materials</b></h3>
                        </div>
                        <hr>
                        <p>Our products have been certified by the V Legal documents, meeting all the necessary export standards that have been laid out by the government.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        /* Activate product menu */
        $(document).ready(function(){
            $('header #menu_about').addClass('active');
        });
    </script>
@stop