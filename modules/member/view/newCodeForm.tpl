<div>
    <form id="newCodeForm" action="post" >
        <ul class="formUl">
           <li class="formLi">
                <label for="oldCode">Gammel kode</label>
                <input type="password" name="oldCode" id="oldCode"/>
            </li>
            <li class="formLi">
                <label for="code1">Ny kode</label>
                <input type="password" name="code1" id="code1"/>
            </li>
                        <li class="formLi">
                <label for="code2">Gjennta ny kode</label>
                <input type="password" name="code2" id="code2"/>
            </li>
            <li class="formLi">
                <input type="button" onclick="saveNewCode()"value="Send inn" name="send"/>
            </li>
        </ul>
    </form>
</div>