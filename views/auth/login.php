<div class="container">
    <div class="row justify-content-center align-items-center g-2 min-vh-100">
        <div class="col-sm-12 col-md-6 bg-white rounded p-3">
            <h3 class="text-center">LOGIN</h3>
            <form action="" method="post">
                <div class="mt-4">
                    <h4 class="text-center text-danger">
                        <?= isset($errors['credential_err']) ? $errors['credential_err'] : '' ?></h4>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control <?= $errors['email'] ? 'is-invalid' : '' ?>"
                            placeholder="Email address.." value="<?= htmlspecialchars($user['email'])  ?>">
                        <small class="form-text text-muted text-danger"><?= $errors['email'] ?></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                            class="form-control <?= $errors['password'] ? 'is-invalid' : '' ?>" placeholder="Password.."
                            value="<?= htmlspecialchars($user['password'])  ?>">
                        <small class="form-text text-muted text-danger"><?= $errors['password'] ?></small>
                    </div>
                    <div class="input-check mb-3">
                        <input type="checkbox" class="check" placeholder="Placeholder" id="check" name="remember_me"
                            <?php if ($user['remember_me']) echo 'checked'; ?>>
                        <label for="check">Remember me</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn">Login</button>
                    </div>
            </form>
            <div class="mt-3 float-end">
                <p>Don't have an account yet? <a href="/register" class="text-primary">Register</a></p>
            </div>
        </div>
    </div>
</div>