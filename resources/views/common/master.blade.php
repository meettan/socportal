<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customer portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/apps.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/apps_inner.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/res.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ url('public/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel='stylesheet'
        type='text/css'>
    <script src="{{ url('public/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type='text/javascript'>
    </script>
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
</head>

<body>
    <div style="    position: fixed;
    width: 100%;
    height: 100%;
    bottom: 0; z-index:100; display:none;" class="" id="closeDropDownBlk">xxx</div>

    <div class="page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="float-left logo"><img src="{{ url('public/images/logo.png') }}" alt="" /> <a href="#"
                    class="closeMenu" id="closeMenuIdNew"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            <ul id="accordion" class="accordion">
                <li>
                    <div class="link"><a href="{{route('dashboard')}}"><i class="fa fa-tachometer"></i>Dashboard</a>
                    </div>
                </li>
                <li>
                    <div class="link"><a href="{{'salesfilter'}}"><i class="fa fa-tachometer"></i>Sale</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{'drcrnote'}}"><i class="fa fa-tachometer"></i>Credit Note</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{'advancefilter'}}"><i class="fa fa-tachometer"></i>Advance</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{'socpayment'}}"><i class="fa fa-tachometer"></i>Money Receipt</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{'socledger'}}"><i class="fa fa-tachometer"></i>Society Ledger</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{'purrep'}}"><i class="fa fa-tachometer"></i>Purchase History</a></div>
                </li>
                <li>
                    <div class="link"><a href="javascript:void(0)"><i class="fa fa-tachometer"></i>Payment History</a>
                    </div>
                </li>
                <li>
                    <div class="link"><a href="{{'paymentlist'}}"><i class="fa fa-tachometer"></i>Pay Now</a></div>
                </li>
                <li>
                    <div class="link"><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i>Log out</a></div>
                </li>
            </ul>
        </nav>
        <div class="main-panel" id="main_panelNew">
            <div class="float-left navRightSec">
                <ul class="topDate">
                    <li id="openSideBar_Li"><a href="#" id="openSideBarId"><i class="fa fa-bars"
                                aria-hidden="true"></i></a></li>
                    <li><a href="{{route('dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                </ul>
                <div class="topDateRight">
                    <ul class="nav topDateRight">
                        <li class="nav-item dropdown">
                            <a href="#" onclick="myFunction()" class="nav-link profileNav" id="profileNavId"><span
                                    class="userNameTopRihght"><?php $soc_name = Auth::user()->soc_name; echo $soc_name;?></span><i
                                    class="fa fa-user-circle" aria-hidden="true"></i> </a>

                            <div id="Demo" class="w3-dropdown-content w3-bar-block w3-border">
                                <div class="subDrop1">
                                    <ul>
                                        <li></li>
                                        <li>{{Session::get('socuserdtls')->district_name}}</li>
                                        <li class="profileLiCus"><a href="{{route('profile')}}">Manage your Profile</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="subDrop2">
                                    <a href="{{route('logout')}}">Loguot</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div id='ajaxview'>
                <!--  Div Statr For Getting Ajax data and page  -->


                @yield('content')


            </div> <!--  Div End For Getting Ajax data and page  -->
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>
    <script>
    function generatePDF() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById('divToPrint');
        // Choose the element and save the PDF for our user.
        html2pdf().from(element).save();
    }
    </script>
    <script src="{{ url('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/js/main_javascript.js') }}"></script>
    <script src="{{ url('public/js/main_jquery.js') }}"></script>

    @yield('script')
</body>

</html>