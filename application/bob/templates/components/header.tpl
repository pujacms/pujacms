<p class="userinfo">
    Welcome <span class="username"><a href="./?module=user" class="profile">{{ current_user.email }}</a></span>,
    <a href="./?module=user&act=reset-password" class="resetPass">Reset password</a> <span class="divider">|</span>
    <a href="./?ctrl=auth&act=logout" class="logout">{{ lang.logout }}Logout</a>
</p>
<h1><a href="./">{{ cfg.company_name }}</a></h1>
