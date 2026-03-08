<h2>Login</h2>
<form method="POST" action="login">
    <?= SecurityHelper::csrf_field() ?>
    <div>
        <label>Username</label><br>
        <input type="text" name="username" placeholder="Username">
    </div>
    <br>
    <button type="submit">Login</button>
</form>
