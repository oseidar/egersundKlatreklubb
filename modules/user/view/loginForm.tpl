<div id="loginFormWrapper">
    <form action="?module=user&action=login&view=default&id=" method="post" >
        
        <ul class="formUl" id="userLoginForm">
            <li>
                <label for="mail">E-post: </label><input type="text" name="mail" id="mail">
            </li>
            <li>
                <label for="password">Passord: </label><input type="text" name="password" id="password">
            </li>
            <li>
                <input type="submit" name="submit" value="Logg på"/>
            </li>
        </ul>
        
    </form>
    Ikke registrert bruker? <a href="?module=user&action=prepareNewUser&view=registerForm&id=">Registrer deg nå</a>
    
</div>