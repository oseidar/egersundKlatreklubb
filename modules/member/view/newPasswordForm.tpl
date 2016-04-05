<div>
    <form action="index.php?module=member&action=setNewPassword&view=myMembership&id=" method="post" >
        
        <ul class="formUl">
           <li class="formLi">
                <label for="oldPass">Gammelt passord</label>
                <input type="password" name="oldPass" id="oldPass"/>
            </li>
            <li class="formLi">
                <label for="password">Nytt passord</label>
                <input type="password" name="password" id="password"/>
            </li>
                        <li class="formLi">
                <label for="password2">Gjenta nytt passord</label>
                <input type="password" name="password2" id="password2"/>
            </li>
            <li class="formLi">
                <input type="submit" value="Send inn" name="send"/>
            </li>
        </ul>
        
    </form>
</div>  