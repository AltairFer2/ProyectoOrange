@extends('layout.orange')
@section('main_content')
<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url(images/img_bg_2.jpg);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc animate-box" data-animate-effect="fadeIn">
                        <h1>Our Blog</h1>
                        <h2>Free html5 templates Made by <a href="http://freehtml5.co" target="_blank">freehtml5.co</a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="pb-0">
    <div class="contact1 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <table id="tblEmployees" class="table">
                        <thead>
                            <tr>
                                <th>NO POST</th>
                                <th>TITLE</th>
                                <th>AUTHOR</th>
                                <th>CONTENT</th>
                                <th>CREATED AT</th>
                                <th>CATEGORY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $pos)
                                <tr>
                                    <td>{{ $posts->no_post ?? ''}}</td>
                                    <td>{{ $posts->title ?? ''}}</td>
                                    <td>{{ $posts->author ?? ''}}</td>
                                    <td>{{ $posts->content ?? ''}}</td>
                                    <td>{{ $posts->created_at ?? ''}}</td>
                                    <td>{{ $posts->category ?? ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
