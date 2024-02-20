<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center mb-4">Send Verification Email</h2>
            <form action="/form/verify/resend" method="post">
                <!-- フォームがcsrfトークンを使用するようになりました。 -->
                <input type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                <div class="mb-3">
                    <h5>Unverified and cannot sign in.</h5>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="new_email" class="form-label">New Email ( If you want to change your email address, also enter New Email. )</label>
                    <input type="email" class="form-control" id="new_email" name="new_email">
                </div>
                <button type="submit" class="btn btn-primary">Send verification email</button>
            </form>
        </div>
    </div>
</div>
