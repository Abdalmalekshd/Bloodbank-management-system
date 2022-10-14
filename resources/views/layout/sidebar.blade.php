<div class="side">
    <div class="sidecont">
        <div class="fa fa-home"><a href={{ route('Home') }}>الرئيسية</a></div>
        <div class="fa fa-user-alt"><a href={{ route('donor') }}> المتبرعين</a></div>
        <div class="fa fa-tint  "><a href={{ route('benifet') }}> المستفيدين</a></div>
        <div class="fa-solid fa-hand-holding-medical"><a href={{ route('exemption') }}> الاعفاء</a></div>
        <div class="dropdown fa fa-list ">
            <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                aria-expanded="false">
                الطلبات
            </a>


            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item " href="{{ route('reqdonationsorder') }}">طلبات المتبرعين</a></li>
                <li><a class="dropdown-item" href="{{ route('reqbenifets') }}">طلبات المستفيدين</a></li>
                <li><a class="dropdown-item" href="{{ route('reqexemp') }}">طلبات الإعفاء</a></li>
            </ul>
        </div>
        <div class="fa fa-sign-out-alt"><a href="{{ route('logout') }}">تسجيل خروج</a></div>
    </div>
</div>
