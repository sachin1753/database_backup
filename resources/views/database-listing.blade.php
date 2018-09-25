<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .sub_title {
                font-size: 44px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="page-wrapper">

            <div class="content">
                <div class="title m-b-md">
                    Download Database
                </div>
                @if(Session::get('flash_success'))
                    <div class="sub_title m-b-md">
                        @if(is_array(json_decode(Session::get('flash_success'), true)))
                            {!! implode('', Session::get('flash_success')->all(':message<br/>')) !!}
                        @else
                            {!! Session::get('flash_success') !!}
                            {{Session::flash('flash_success', '')}}
                        @endif
                    </div>
                @endif
                <div class="content m-b-md">
                    Click on database name to download database, to download all databases click on Download All link
                </div>
                <div class="links m-b-md">
                    @foreach($databaseList as $list)
                    <a href="{!! route('save') !!}?dbName={{$list}}">{{$list}}</a>
                    @endforeach
                </div>
                <div class="links">
                    <a class="btn" href="{!! route('save_all') !!}"><i class="fa fa-download"></i> Download All</a>
                </div>
            </div>
        </div>
    </body>
</html>
