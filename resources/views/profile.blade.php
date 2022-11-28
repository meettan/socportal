<?php echo View::make('common/header'); ?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Profile</h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="wrapper_fixed">
                            <div class="row">
                                <div class="signUpCardLayoutMain">
                                    <div class="signUpCardLayout-card memberShipArea" style="padding-bottom: 0;">

                                        <ul class="tabUl nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-user"
                                                        aria-hidden="true"></i> Profile</a></li>
                                            <li><a data-toggle="tab" href="#menu1"><i class="fa fa-unlock-alt"
                                                        aria-hidden="true"></i> Change Password</a></li>
                                            <li>@if(Session::has('error'))
                                                    <div class="alert alert-danger">
                                                    {{ Session::get('error')}}
                                                    </div>
                                                    @endif 
                                                    @if(Session::has('success'))
                                                    <div class="alert alert-success">
                                                    {{ Session::get('success')}}
                                                    </div>
                                                    @endif 
                                            </li>           

                                        </ul>
                                        <div class="tab-content">
                                            <div id="home" class="tab-pane fade in active tabContent">
                                            <!-- <form action ="{{'profile_update'}}" method="post">
                                                @csrf -->
                                                <input type="hidden" value="{{Auth::user()->id}}" name="id">
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>Pan No:</span> <input type="text" name="pan" readonly
                                                            value="{{$users->pan}}">
                                                    </div>
                                                </div>
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>Name Of Society:</span> <input type="text" name="soc_name"
                                                            value="{{$users->soc_name}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>Email Id:</span><input type="email" name="email"
                                                            value="{{Session::get('socuserdtls')->email}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="full_field_col3_full">
                                                    <div class="textFieldSec">
                                                        <span>Address:</span><textarea
                                                            name="soc_address" readonly>{{Session::get('socuserdtls')->soc_add}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>Mobile:</span> <input type="text" name="ph_number"
                                                            value="{{Session::get('socuserdtls')->ph_no}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>GSTIN:</span> <input type="text" name="gstin"
                                                            value="{{Session::get('socuserdtls')->gstin}}" readonly/>
                                                    </div>
                                                </div>
                                                <div class="full_field_col3">
                                                    <div class="textFieldSec">
                                                        <span>mFMS</span> <input type="text" name="mfms"
                                                            value="{{Session::get('socuserdtls')->mfms}}" readonly />
                                                    </div>
                                                </div>
                                                	<div class="full_field_col3"></div>
                                            <!-- </form> -->
                                            </div>
                                            <div id="menu1" class="tab-pane fade tabContent">
                                            <form action ="{{'password_update'}}" method="post">
                                                @csrf
                                                <div class="full_field_col3_full"><input type="password"
                                                        placeholder="Old Password" name="old_password"></div>

                                                <div class="full_field_col3Half"><input type="password"
                                                        placeholder="New Password" name="password" id="password"></div>

                                                <div class="full_field_col3Half"><input type="text"
                                                        placeholder="Confirm Password" name="confirm_password" id="confirm_password"></div>

                                                <!-- <div class="full_field_col3_full"><input type="submit" value="Confirm"> -->
                                                <div class="full_field_col3"><input type="submit" class="btn btn-primary" value="submit"></div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo View::make('common/footer'); ?>