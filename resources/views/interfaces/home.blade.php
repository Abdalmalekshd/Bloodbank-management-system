<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('Home.css') }}">
    <link rel="stylesheet" href=" {{ asset('css1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css1/all.min.css') }}">
    <title>Home</title>
</head>

<body>
    <form class="page">
        <header class="head">

            blood bank management system
            </button>
        </header>
        @include('layout.sidebar')
        <section class="contain">
            <div class="con">

                <h3>avaliable blood for every blood type</h3>
                <div class="divcon">
                    @foreach ($blood as $blo)
                        <div class=" fa fa-tint a1">
                            <p>{{ $blo->blood_group }}</p>
                            <p class="count">{{ $blo->amount }}</p>
                        </div>
                    @endforeach
                    <div class="fa fa-user-friends">
                        <p>إجمالي المتبرعين</p>
                        <p class="count">{{ $don }}</p>
                    </div>
                    <div class="fa fa-check">
                        <p>المستفيدين اليوم</p>
                        <p class="count">{{ $todayben }}</p>
                    </div>
                    <div class="fa fa-notes-medical">
                        <p>المتبرعين اليوم</p>
                        <p class="count">{{ $todaydon }}</p>
                    </div>
                    <div class="fa fa-list">
                        <p>إجمالي المستفيدين</p>
                        <p class="count">{{ $ben }}</p>
                    </div>
                </div>
            </div>
        </section>
    </form>






    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
