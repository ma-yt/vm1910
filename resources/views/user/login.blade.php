<html>
    <form action="/user/logindo" method="post">
        @csrf
        用户名:<input type="text" name="user_name"><br/>
         密码:<input type="password" name="password"><br/>
            <input type="submit" value="登录">
    </form>
</html>