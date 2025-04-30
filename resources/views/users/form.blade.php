<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
   <div>
      <?php
         $id = $id ?? null;
      ?>
      @if(isset($id))
      {!! Form::model($data, ['route' => ['users.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
      @else
      {!! Form::open(['route' => ['users.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif
      <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Informasi User</h4>
                </div>
                <div class="card-action">
                    <a href="{{route('users.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="fname">First Name: <span class="text-danger">*</span></label>
                            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'First Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="lname">Last Name: <span class="text-danger">*</span></label>
                            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Last Name' ,'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="email">Email: <span class="text-danger">*</span></label>
                            {{ Form::email('email', old('email'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Enter E-Mail', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="pass">Password: <span class="text-danger">*</span></label>
                            {{ Form::password('password', ['class' => 'form-control placeholder-grey', 'placeholder' => 'Password']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">User Role: <span class="text-danger">*</span></label>
                            {{Form::select('user_type', $roles , old('user_type') ? old('user_type') : $data->user_type ?? 'user', ['class' => 'form-control placeholder-grey', 'placeholder' => 'Select User Role'])}}
                         </div>
                         <div class="form-group col-md-6">
                             <label class="form-label" for="pno">Phone Number:</label>
                             {{ Form::number('phone_number', old('phone_number'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Enter Phone Number']) }}
                         </div>
                        {{-- <div class="form-group">
                            <div class="profile-img-edit position-relative">
                            <img src="{{ $profileImage ?? asset('images/avatars/01.png')}}" alt="User-Profile" class="profile-pic rounded avatar-100">
                               <div class="upload-icone bg-primary">
                                  <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                     <path fill="#ffffff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                  </svg>
                                  <input class="file-upload" type="file" accept="image/*" name="profile_image">
                               </div>
                            </div>
                            <div class="img-extension mt-3">
                               <div class="d-inline-block align-items-center">
                                  <span>Only</span>
                                  <a href="javascript:void();">.jpg</a>
                                  <a href="javascript:void();">.png</a>
                                  <a href="javascript:void();">.jpeg</a>
                                  <span>allowed</span>
                               </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <hr>
                    <h5 class="mb-3">Security</h5>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label" for="uname">User Name: <span class="text-danger">*</span></label>
                            {{ Form::text('username', old('username'), ['class' => 'form-control placeholder-grey', 'required', 'placeholder' => 'Enter Username']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="pass">Password:</label>
                            {{ Form::password('password', ['class' => 'form-control placeholder-grey', 'placeholder' => 'Password']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="rpass">Repeat Password:</label>
                            {{ Form::password('password_confirmation', ['class' => 'form-control placeholder-grey', 'placeholder' => 'Repeat Password']) }}
                        </div>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} User</button>
                </div>
            </div>
        </div>
      </div>
      {!! Form::close() !!}
   </div>
</x-app-layout>
