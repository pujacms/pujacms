<p class="userinfo">
    Welcome <span class="username">{{ current_user.email }}</span>,
    <a href="?mod=user&act=update" class="profile">{{ lang.profile }}Profile</a> or
    <a href="?mod=user&act=reset" class="resetPass">{{ lang.reset_psw }}</a> <span class="divider">|</span>
    <a href="?ctrl=auth&act=logout" class="logout">{{ lang.logout }}Logout</a>
</p>
<h1><a href="./">{{ cfg.company_name }}</a></h1>
