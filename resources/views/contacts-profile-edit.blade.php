@extends('layouts.master-layouts')
@section('title')
    @lang('translation.ProfileEdit')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Profile @endslot
        @slot('title') Edit Profile @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('contacts-profile/update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-4 px-4">  <!-- Personal Data -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Personal Data</h4>
                            <div class="mb-4 row">
                                <label for="username" class="col-md-3 col-form-label">Username</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->username}}" id="username" name="username" disabled>
                                </div>
                            </div>
                            <!-- Image Part -->

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Profile Image</label>
                                <div class="col-md-9">
                                    <div class="profile-pic-wrapper">
                                        <div class="pic-holder">
                                            <!-- uploaded pic shown here -->
                                            <img id="profilePic" class="pic" src="{{asset($user->avatar)}}">

                                            <label for="newProfilePhoto" class="upload-file-block">
                                            <div class="text-center">
                                                <div class="mb-2">
                                                <i class="fa fa-camera fa-2x"></i>
                                                </div>
                                                <div class="text-uppercase">
                                                Update <br /> Profile Photo
                                                </div>
                                            </div>
                                            </label>
                                            <Input class="uploadProfileInput" type="file" name="profile_pic" id="newProfilePhoto" accept="image/*" style="display:none"/>
                                        </div>

                                        </hr>
                                        <p class="text-info text-center small">Note: Selected image will not be uploaded </br>until you click save.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- --------- -->
                            <div class="mb-3 row">
                                <label for="gender" class="col-md-3 col-form-label">Please select</label>
                                <div class="col-md-9">
                                    <select class="form-select" style="max-width: 100px;" id="gender" name="gender">
                                        <option {{$user->gender == 'Male' ? 'Selected' : ''}}>Male</option>
                                        <option {{$user->gender == 'Female' ? 'Selected' : ''}}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="firstname" class="col-md-3 col-form-label">First name</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->firstname}}" id="firstname" name="firstname">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="lastname" class="col-md-3 col-form-label">Last name</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->lastname}}" id="lastname" name="lastname">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="city" class="col-md-3 col-form-label">City</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->city}}" id="city" name="city">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="country" class="col-md-3 col-form-label">Country</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->country}}" id="country" name="country">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="birthdate" class="col-md-3 col-form-label">Date of birth</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="date" value="{{$user->birthdate}}" id="birthdate" name="birthdate" style="max-width:170px;">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="bio" class="col-md-3 col-form-label">About me</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="In a few words, tell us about yourself" rows="5" id="bio" name="bio">{{$user->bio}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-4">  <!-- Online Profile & Options -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Online Profiles</h4>
                            <div class="mb-3 row">
                                <label for="facebook" class="col-md-4 col-form-label">Facebook</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->facebook}}" id="facebook" name="facebook" placeholder="https://www.facebook.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="twitter" class="col-md-4 col-form-label">Twitter</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->twitter}}" id="twitter" name="twitter" placeholder="https://www.twitter.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="instagram" class="col-md-4 col-form-label">Instagram</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->instagram}}" id="instagram" name="instagram" placeholder="https://www.instagram.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="soundcloud" class="col-md-4 col-form-label">SoundCloud</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->soundcloud}}" id="soundcloud" name="soundcloud" placeholder="https://www.soundcloud.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="youtube" class="col-md-4 col-form-label">YouTube</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->youtube}}" id="youtube" name="youtube" placeholder="https://www.youtube.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="website" class="col-md-4 col-form-label">Website</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->website}}" id="website" name="website" placeholder="Your website url">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="patreon" class="col-md-4 col-form-label">Patreon</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->patreon}}" id="patreon" name="patreon" placeholder="Patreon">
                                </div>
                            </div>

                            <h4 class="font-size-18 pb-2 mt-4 mb-4 border-bottom border-2">Options</h4>
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label">Email address</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{$user->email}}" id="email" name="email" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label">Password</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" value="" id="password" name="password" placeholder="Leave blank if you don't want to change">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="confirmPassword" class="col-md-4 col-form-label">Confirm Password</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" value="" id="confirmPassword" name="confirmPassword" placeholder="Leave blank if you don't want to change">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="signinwith" class="col-md-4 col-form-label">Sign in with</label>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-rounded mx-2 {{array_key_exists("0", $user->signinwiths) ? ($user->signinwiths['0'] == 1 ? 'btn-secondary' : 'btn-light') : 'btn-light'}}" style="width: 100px;" onclick="toogleSign(this, 0)" data-status="{{array_key_exists("0", $user->signinwiths) ? ($user->signinwiths['0'] == 1 ? 'active' : 'inactive') : 'inactive'}}" >Facebook</button>
                                    <button type="button" class="btn btn-rounded mx-2 {{array_key_exists("1", $user->signinwiths) ? ($user->signinwiths['1'] == 1 ? 'btn-secondary' : 'btn-light') : 'btn-light'}}" style="width: 100px;" onclick="toogleSign(this, 1)" data-status="{{array_key_exists("1", $user->signinwiths) ? ($user->signinwiths['1'] == 1 ? 'active' : 'inactive') : 'inactive'}}">Google</button>
                                </div>
                                <input class="form-control" type="text" value="{{$user->signinwith}}" id="signinwith" name="signinwith" hidden>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label pt-0">Communication</label>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="communiation_private_messages" {{array_key_exists("0", $user->communications) ? ($user->communications["0"] == 1 ? 'checked' : '') : '' }} onclick="toogleCommunication(this, 0)">
                                        <label class="form-check-label" for="communiation_private_messages">
                                            Disable private messages
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="communiation_comments" {{array_key_exists("1", $user->communications) ? ($user->communications["1"] == 1 ? 'checked' : '') : '' }}  onclick="toogleCommunication(this, 1)">
                                        <label class="form-check-label" for="communiation_comments">
                                            Disable comments
                                        </label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" value="{{$user->communication}}" id="communication" name="communication" hidden>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label pt-0">Email notifications</label>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_private_messages" {{array_key_exists("0", $user->emailNotifications) ? ($user->emailNotifications["0"] == 1 ? 'checked' : '') : '' }} onclick="toogleNotification(this, 0)">
                                        <label class="form-check-label" for="email_private_messages">
                                            private messages
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_news" {{array_key_exists("1", $user->emailNotifications) ? ($user->emailNotifications["1"] == 1 ? 'checked' : '') : '' }} onclick="toogleNotification(this, 1)">
                                        <label class="form-check-label" for="email_news">
                                            Send me latest news and tips
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_important" {{array_key_exists("2", $user->emailNotifications) ? ($user->emailNotifications["2"] == 1 ? 'checked' : '') : '' }} onclick="toogleNotification(this, 2)">
                                        <label class="form-check-label" for="email_important">
                                            Send me latest important notifications
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_comments" {{array_key_exists("3", $user->emailNotifications) ? ($user->emailNotifications["3"] == 1 ? 'checked' : '') : '' }} onclick="toogleNotification(this, 3)">
                                        <label class="form-check-label" for="email_comments">
                                            Notify me of new comments
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_new_images" {{array_key_exists("4", $user->emailNotifications) ? ($user->emailNotifications["4"] == 1 ? 'checked' : '') : '' }} onclick="toogleNotification(this, 4)">
                                        <label class="form-check-label" for="email_new_images">
                                            Notify me of new images uploaded by friends
                                        </label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" value="{{$user->emailNotification}}" id="emailNotification" name="emailNotification" hidden>

                            </div>
                        </div>
                        <div class="col-lg-4 px-4">  <!-- Crypto Wallets & To receive donations -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Crypto Wallets</h4>
                            <?php $index = 0; foreach($cryptos as $crypto) { $index ++;?>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">{{ $crypto->name }}</label>
                                <div class="col-md-9">
                                    <input class="form-control crypto" type="text" value="{{array_key_exists($crypto->name, $user->cryptos) ? $user->cryptos[$crypto->name] : ''}}" id="crypto_{{$index}}" data-key = "{{ $crypto->name }}">
                                </div>
                            </div>
                            <?php } ?>
                            <input class="form-control" type="text" value="{{$user->cryptoSet}}" id="cryptoSet" name="cryptoSet" hidden>

                            <h4 class="font-size-18 pb-2 mt-4 mb-4 border-bottom border-2">To receive donations</h4>
                            <div class="mb-3 row">
                                <label for="id" class="col-md-3 col-form-label">Paypal</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->paypal}}" id="paypal" name="paypal">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="stripe" class="col-md-3 col-form-label">Stripe</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->stripe}}" id="stripe" name="stripe">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="zelle" class="col-md-3 col-form-label">Zelle</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->zelle}}"id="zelle" name="zelle">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="venmo" class="col-md-3 col-form-label">Venmo</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->venmo}}" id="venmo" name="venmo">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="cashapp" class="col-md-3 col-form-label">CashApp</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{$user->cashapp}}" id="cashapp">
                                </div>
                            </div>

                            <h3 id="btn_change_status" class="font-size-24 pb-2 mb-2 text-danger" style="margin-top:80px; cursor:pointer;" data-id="{{ $user->id }}" data-status="{{$user->status}}">{{ $user->status == 'active' ? "Deactive account" : "Active account" }}</h3>
                            <button type="submit" class="px-4 w-100 font-size-18 btn btn-success btn-rounded waves-effect waves-light">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script-bottom')
    <script>
        function toogleSign(obj, type) {
            var str = $("#signinwith").val();
            var singInWith = {};
            if(str != '')
            {
                singInWith = JSON.parse($("#signinwith").val());
            }            

            var jobj = $(obj);
            var status = jobj.attr('data-status');
            if(status == 'active'){                
                jobj.attr('data-status', 'inactive');
                jobj.removeClass('btn-secondary');
                jobj.addClass('btn-light');

                singInWith[type] = 0;

            }
            else{
                jobj.attr('data-status', 'active');
                jobj.removeClass('btn-light');
                jobj.addClass('btn-secondary');
                singInWith[type] = 1;
            }

            $("#signinwith").val(JSON.stringify(singInWith));
        }

        function toogleCommunication(obj, type) {
            var str = $("#communication").val();
            var communication = {};
            if(str != '')
            {
                communication = JSON.parse($("#communication").val());
            }            

            var jobj = $(obj);
            communication[type] = jobj[0]['checked'] ? 1 : 0;
            $("#communication").val(JSON.stringify(communication));
        }

        function toogleNotification(obj, type) {
            var str = $("#emailNotification").val();
            var emailNotification = {};
            if(str != '')
            {
                emailNotification = JSON.parse($("#emailNotification").val());
            }            

            var jobj = $(obj);
            emailNotification[type] = jobj[0]['checked'] ? 1 : 0;
            $("#emailNotification").val(JSON.stringify(emailNotification));
        }

        $(document).on("change", ".uploadProfileInput", function () {
            var triggerInput = this;
            var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
            var holder = $(this).closest(".pic-holder");
            var wrapper = $(this).closest(".profile-pic-wrapper");
            $(wrapper).find('[role="alert"]').remove();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                return;
            }

            if (/^image/.test(files[0].type)) {
                // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () {
                    $(holder).addClass("uploadInProgress");
                    $(holder).find(".pic").attr("src", this.result);
                    $(holder).append(
                        '<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );

                    // Dummy timeout; call API or AJAX below
                    setTimeout(() => {
                        $(holder).removeClass("uploadInProgress");
                        $(holder).find(".upload-loader").remove();
                        // If upload successful
                        if (Math.random() < 0.9) {
                            $(wrapper).append(
                                '<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>'
                            );

                            // Clear input after upload
                            // $(triggerInput).val("");

                            setTimeout(() => {
                                $(wrapper).find('[role="alert"]').remove();
                            }, 3000);
                        } else {
                            $(holder).find(".pic").attr("src", currentImg);
                            $(wrapper).append(
                                '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Please try again later.</div>'
                            );

                            // Clear input after upload
                            // $(triggerInput).val("");
                            setTimeout(() => {
                                $(wrapper).find('[role="alert"]').remove();
                            }, 3000);
                        }
                    }, 1500);
                };
            } else {
                $(wrapper).append(
                    '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
                );
                setTimeout(() => {
                    $(wrapper).find('role="alert"').remove();
                }, 3000);
            }
        });

        $('.crypto').keyup(function(){
            var crypto_key = $(this).attr('data-key');
            
            var str = $("#cryptoSet").val();
            var cryptoSet = {};
            if(str == '')
            {
                cryptoSet = {};
            } else {
                cryptoSet = JSON.parse($("#cryptoSet").val());
            }
            cryptoSet[crypto_key] = $(this).val();
            console.log(cryptoSet);
            console.log(JSON.stringify(cryptoSet));


            $("#cryptoSet").val(JSON.stringify(cryptoSet));
        });

        $("#btn_change_status").click(function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            $this = $(this);

            Swal.fire({
                title: "Are you sure to " + (status == 'active' ? 'deactive' : 'active') + " account?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, " + (status == 'active' ? 'Deactive' : 'Active') + "!"
            }).then(function (result) {
                if (result.value) {
                    var param = {
                        id : id,
                        status : (status == 'active' ? 'deactive' : 'active'),
                    };
                    $.ajax({
                        url: "{{URL::to('/contacts-profile/changeStatus')}}",
                        type: 'POST',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify(param),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            $this.attr('data-status', (status == 'active' ? 'deactive' : 'active'));
                            $this.html(status == 'active' ? 'Active account' : 'Deactive account');
                        },
                    });
                    
                }
            });
        })
    </script>
@endsection