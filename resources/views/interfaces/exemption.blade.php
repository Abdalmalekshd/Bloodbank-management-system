@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('reqdonor.css') }}">
@section('Title', 'exemption_orders')

@section('content')
    <section class="contain">
        <div class="con">

            <h3>قائمة المعفيين</h3>
            <div class="divcon">
                <table class="table">
                    <tr>
                        <th class="id">ID</th>
                        <th>الاسم الكامل</th>
                        <th>نوع الدم</th>
                        <th>معلومات اضافية</th>
                        <th>سبب التبرع</th>
                        <th>سبب الاعفاء</th>
                        <th>الوقت</th>

                    </tr>
                    @if (isset($orders) && $orders->count() > 0)
                        @foreach ($orders as $ord)
                            <tr class="DonRow{{ $ord->id }}">
                                <td class="id">{{ $ord->id }}</td>
                                <td>{{ $ord->order->name }}</td>

                                <td>
                                    @foreach ($bloods as $item)
                                        @if ($ord->order->blood_id == $item->id)
                                            {{ $item->blood_group }}
                                        @endif
                                    @endforeach
                                </td>

                                <td> {{ $ord->order->id_num }} <br> {{ $ord->order->phone }}</td>
                                <td>{{ $ord->reason_for_don }}</td>

                                <td>{{ $ord->reason_for_exe }}</td>
                                <td>{{ $ord->order->date }}</td>

                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


    {{-- Serach TextBox --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var filter = $(this).val(),
                    count = 0;
                $(".table tr").each(function() {
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
                    } else {
                        $(this).show();
                        count++;
                    }
                });

                var numberItems = count;
                $("#result-count").text("Number of Results = " + count);
            });
        });
    </script>


    <Div class="links">{!! $orders->links() !!}</Div>

@endsection
