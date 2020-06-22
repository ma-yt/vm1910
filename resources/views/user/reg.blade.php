<html>
    <form action="/user/regdo" method="post">
        @csrf
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td><input type="password" name="password1"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="注册"></td>
            </tr>
        </table>
    </form>

</html>