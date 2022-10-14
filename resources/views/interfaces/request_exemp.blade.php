@extends('layout.admin')
<link rel="stylesheet" href="{{ asset('reqdonor.css') }}">
@section('Title', 'exemption')

@section('content')


    <section class="contain">
        <div class="con">

            <h3>طلبات الإعفاء</h3>
            <div class="divcon">

                <table class="table">
                    <tr>
                        <th class="id">ID</th>
                        <th>الاسم كامل</th>
                        <th>نوع الدم</th>
                        <th>معلومات اضافية</th>
                        <th>سبب التبرع</th>
                        <th>سبب الاعفاء</th>
                        <th>الوقت</th>

                        {{-- <th colspan="3"></th> --}}
                    </tr>

                    @if (isset($orders) && $orders->count() > 0)
                        @foreach ($orders as $ord)
                            <tr>
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




                                <td colspan="3" class="w-25">
                                    <a href="{{ route('Delete.Exemption', $ord->order->id) }}"
                                        class="delete_btn fa-solid fa-xmark
        btn btn-danger rounded-pill border border-0 ps-2">حذف</a>

                                    <a href="{{ route('exemption.edit', $ord->id) }}"
                                        class="fa-solid fa-user-pen
            btn btn-primary rounded-pill border border-0 ">تعديل</a>

                                    <a id="open-ben1-btn" class="d-none" data-bs-toggle="modal" data-bs-target="#ben1"></a>



                                    <a href="{{ route('order.exe.approved', $ord->order->id) }}"
                                        class="fa-solid fa-check
        btn btn-success rounded-pill border border-0 "
                                        style="color: white">تأكيد</a>
                        @endforeach
                    @endif


                </table>


            </div>

        </div>

    </section>



    <!-- MODAL New Exemption-->
    @if ($exemption)
        <div class="modal fade border border-3 shadow-lg" id="ben1" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="hedar">
                        <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal"></button>
                        <label class="ms-3 mt-3">
                            <h3>New Exemption</h3>
                        </label>
                        <hr width=100% color=#898585>
                    </div>
                    <div class="modal-body col-sm-12">

                        <form method="POST" id="exem_form" enctype="multipart/form-data"
                            action="{{ route('order.exe.update') }}">
                            @csrf


                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $exemption->id }}" class="d-none" />

                                <label class="control-label ps-3">الاسم كامل</label><br>
                                <input type="text" class="form-control ms-1" placeholder="Enter Your Name" name="name"
                                    value="{{ $exemption->order->name }}">
                            </div>




                            <div class="form-group">
                                <label for="" class="control-label ps-3">الرقم الوطني</label><br>
                                <input type="text" class="form-control ms-1" placeholder="Enter Your Id-Number"
                                    name="id_num" value="{{ $exemption->order->id_num }}">
                            </div>


                            <div class="form-group">
                                <label for="" class="control-label ps-3">رقم الجوال</label><br>
                                <input type="text" class="form-control ms-1" name="phone"
                                    placeholder="Enter Your Phone-Number" value="{{ $exemption->order->phone }}">
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label ps-3">سبب التبرع</label><br>
                                <select class="custom-select m-1" name='reason_for_don'
                                    value={{ $exemption->reason_for_don }}>
                                    <option>اجازة سوق</option>
                                    <option>دفتر خدمة العلم</option>
                                    <option>تطوع في الجيش</option>
                                    <option>تخرج</option>
                                    <option>عمل جديد</option>
                                    <option>طوعي</option>
                                    <option>اشياء اخرى</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label ps-3 ">سبب الاعفاء</label>
                                <select class="custom-select m-1" name='reason_for_exe'
                                    value="{{ $exemption->reason_for_exe }}">
                                    <option>مرض</option>
                                    <option>وزن اقل من 50</option>
                                    <option>خضاب قليل</option>
                                    <option>اشياء اخرى</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label ps-3">Blood Type</label><br>
                                <select name="blood_id" id="" class="custom-select m-1">
                                    @foreach ($bloods as $item)
                                        @if ($item->id == $exemption->order->blood_id)
                                            <option selected value="{{ $item->id }}">
                                                {{ $item->blood_group }}
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->blood_group }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id='update_exe' class="btn btn-outline-danger float-end me-3">Save</button>

                        <button type="reset" class="btn btn-outline-primary float-end mt-2 ms-5"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>

                    </form>


                </div>

            </div>
        </div>
        </div>
    @endif



@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('open-ben1-btn').click()
    });
</script>


<script>
    $(document).ready(function() {

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


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
