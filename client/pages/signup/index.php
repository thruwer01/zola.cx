<div class="flex-fill d-flex flex-column justify-content-center py-4">
  <div class="container-tight py-6">
    <div class="card card-md">
      <div class="card-body">
        <div class="alert" id="alert" role="alert" style="display:none;">
            <h4 class="alert-title" id="alertTitle"></h4>
          </div>
        <h2 class="card-title text-center mb-4">Sign up</h2>
        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="text" class="form-control" id="email" required name="email" placeholder="Your email">
        </div>
        <div class="mb-2">
          <label class="form-label">
            Password
          </label>
          <div class="input-group input-group-flat">
            <input type="password" name="password" class="form-control" required id="password" placeholder="Password" autocomplete="off">
          </div>
        </div>
        <div class="form-footer">
          <button class="btn btn-primary w-100" id="signUpBtn">Sign up</button>
        </div>
      </div>
    </div>
  </div>
</div>