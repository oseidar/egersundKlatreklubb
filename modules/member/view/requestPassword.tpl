<div class="contentWrapper">

    <h3>Be om nytt passord</h3>
    <p>Skriv inn din epost og fornavnet ditt i feltene under:</p>
    <form method="post" action="index.php?module=member&action=requestPassword&view=blank&id=">
        <ul class="formUl">
            <li>
                <label for="mail">E-post</label>
                <input type="text" name="mail" id="mail">
            </li>
            <li>
                <label for="firstName">Fornavn</label>
                <input type="text" name="firstName" id="firstName">
            </li>
            <li>
                
                <button name="send" type="submit" >Send inn </button>
            </li>
        </ul>
    </form>
</div>