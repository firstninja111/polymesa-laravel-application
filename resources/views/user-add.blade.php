@extends('layouts.master-layouts')
@section('title')
    @lang('translation.UserAdd')
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Users @endslot
        @slot('title') Add User @endslot
        @slot('sub_title')  @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('users/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-4">
                    <div class="row">
                        
                        <div class="col-lg-4 px-4">  <!-- Personal Data -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Personal Data</h4>
                            <div class="mb-4 row">
                                <label for="username" class="col-md-3 col-form-label">Username<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text"  value="{{old('username')}}" id="username" name="username" required>
                                </div>
                            </div>
                            <!-- Image Part -->
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Profile Image</label>
                                <div class="col-md-9">
                                    <div class="profile-pic-wrapper">
                                        <div class="pic-holder">
                                            <!-- uploaded pic shown here -->
                                            <img id="profilePic" class="pic" src="{{asset('public/assets/images/users/default-avatar.png')}}">

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
                                            <Input class="uploadProfileInput" type="file" name="profile_pic" id="newProfilePhoto" accept="image/*" style="display: none;" />
                                        </div>

                                        </hr>
                                        <p class="text-info text-center small">Note: Selected image will not be uploaded </br>until you click save.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- --------- -->
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Please select<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <select class="form-select" style="max-width: 100px;" name="gender" id="gender">
                                        <option selected>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">First name<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('firstname')}}" id="firstname" name="firstname" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Last name<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('lastname')}}" id="lastname" name="lastname" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">City<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('city')}}" id="city" name="city" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Country<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('country')}}" id="country" name="country" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Date of birth<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="date" value="{{old('birthdate')}}" id="birthdate" name="birthdate" style="max-width:170px;" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">About me</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" placeholder="In a few words, tell us about yourself" rows="3" id="bio" name="bio">{{old('bio')}}</textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">User Type<span class="text-danger fw-bold"> </span></label>
                                <div class="col-md-9">
                                    <select class="form-select" style="max-width: 150px;" name="userType" id="userType">
                                        <option selected>freshman</option>
                                        <option>junior</option>
                                        <option>senior</option>
                                        <option>unlimited</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-4">  <!-- Online Profile & Options -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Online Profiles</h4>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Facebook</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('facebook')}}" id="facebook" name="facebook" placeholder="https://www.facebook.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Twitter</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('twitter')}}" id="twitter" name="twitter" placeholder="https://www.twitter.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Instagram</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('instagram')}}" id="instagram" name="instagram" placeholder="https://www.instagram.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">SoundCloud</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('soundcloud')}}" id="soundcloud" name="soundcloud" placeholder="https://www.soundcloud.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">YouTube</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('youtube')}}" id="youtube" name="youtube" placeholder="https://www.youtube.com/...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Website</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('website')}}" id="website" name="website" placeholder="Your website url">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Patreon</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="{{old('patreon')}}" id="patreon" name="patreon" placeholder="Patreon">
                                </div>
                            </div>

                            <h4 class="font-size-18 pb-2 mt-4 mb-4 border-bottom border-2">Options</h4>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Email address<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="email" value="{{old('email')}}" id="email" name="email" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Password<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" value="{{old('password')}}" id="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Confirm Password<span class="text-danger fw-bold"> *</span></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="password" value="{{old('confirmPassword')}}" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Sign in with</label>
                                <div class="col-md-8">
                                    <button type="button" class="btn btn-light btn-rounded mx-2" style="width: 100px;" onclick="toogleSign(this, 0)" data-status="inactive" >Facebook</button>
                                    <button type="button" class="btn btn-light btn-rounded mx-2" style="width: 100px;" onclick="toogleSign(this, 1)" data-status="inactive" >Google</button>
                                </div>
                                <input class="form-control" type="text" value="" id="signinwith" name="signinwith" hidden>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label pt-0">Communication</label>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="communiation_private_messages" onclick="toogleCommunication(this, 0)">
                                        <label class="form-check-label" for="communiation_private_messages">
                                            Disable private messages
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="communiation_comments" onclick="toogleCommunication(this, 1)">
                                        <label class="form-check-label" for="communiation_comments">
                                            Disable comments
                                        </label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" value="" id="communication" name="communication" hidden>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-4 col-form-label pt-0">Email notifications</label>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_private_messages" onclick="toogleNotification(this, 0)">
                                        <label class="form-check-label" for="email_private_messages">
                                            private messages
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_news" onclick="toogleNotification(this, 1)">
                                        <label class="form-check-label" for="email_news">
                                            Send me latest news and tips
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_important" onclick="toogleNotification(this, 2)">
                                        <label class="form-check-label" for="email_important">
                                            Send me latest important notifications
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_comments" onclick="toogleNotification(this, 3)">
                                        <label class="form-check-label" for="email_comments">
                                            Notify me of new comments
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_new_images" onclick="toogleNotification(this, 4)">
                                        <label class="form-check-label" for="email_new_images">
                                            Notify me of new images uploaded by friends
                                        </label>
                                    </div>
                                </div>
                                <input class="form-control" type="text" value="" id="emailNotification" name="emailNotification" hidden>
                            </div>
                        </div>
                        <div class="col-lg-4 px-4">  <!-- Crypto Wallets & To receive donations -->
                            <h4 class="font-size-18 pb-2 mb-4 border-bottom border-2">Crypto Wallets</h4>
                            <?php $index = 0; foreach($cryptos as $crypto) { $index ++;?>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">{{ $crypto->name }}</label>
                                <div class="col-md-9">
                                    <input class="form-control crypto" type="text" value="" id="crypto_{{$index}}" data-key = "{{ $crypto->name }}">
                                </div>
                            </div>
                            <?php } ?>
                            <input class="form-control" type="text" value="" id="cryptoSet" name="cryptoSet" hidden>

                            <h4 class="font-size-18 pb-2 mt-4 mb-4 border-bottom border-2">To receive donations</h4>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Paypal</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('paypal')}}" id="paypal" name="paypal">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Stripe</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('stripe')}}" id="stripe" name="stripe">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Zelle</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('zelle')}}" id="zelle" name="zelle">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">Venmo</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('venmo')}}" id="venmo" name="venmo">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-3 col-form-label">CashApp</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" value="{{old('cashapp')}}" id="cashapp" name="cashapp">
                                </div>
                            </div>

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
        })
    </script>
@endsection