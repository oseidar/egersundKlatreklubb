<div id="loginFormDiv">
    
    <form action="index.php?module=member&action=doLogin&view=blank&id=" method="post">
        
    
        <ul class="formUl">
           <li class="formLi">
                <label for="mail">Brukernavn(E-posten du registrerte med)</label>
                <input type="text" name="mail" id="mail"/>
            </li>
            <li class="formLi">
                <label for="password">Passord</label>
                <input type="password" name="password" id="password"/>
            </li>
            <li class="formLi">
                <input type="submit" value="Send inn" name="send"/>
            </li>
        </ul>

    </form>

<p>Ikke registrert i systemet ? <a href="?module=member&action=register&view=registerForm&id=">Registrer deg her</a></p>
<p>Glemt passord? <a href="index.php?module=member&action=&view=requestPassword&id=">Be om nytt passord her</a></p>
</div>