<form id="newMemberForm"
    <div id="formContentWrapper">
        <fieldset >
            <legend ><span class="legendSpan">Rediger bruker:</span></legend>
                <div class="inlineBlock">
                    <ul class="formUl">
                        <input type="text" name="pawned" style="display: none"/>
                        <li>
                            <label for="firstName">Fornavn:</label><input type="text" name="firstName" id="firstName" value=""/>
                        </li>
                        <li>
                            <label for="lastName">Etternavn:</label><input type="text" name="lastName" id="lastName" value=""/>
                        </li>
                        <li>
                            <label for="adress">Adresse:</label><input type="text" name="adress" id="adress" value=""/>
                        </li>
                        <li>
                        <label for="zip>">Postnr:</label><input type="text" name="zip" id="zip"  value=""/>
                       
                        </li>
                       
                    </ul>

                </div>
                <div class="inlineBlock">
                    <ul class="formUl">
                         <li>
                        <label for="phone">Telefon:</label><input type="text" name="phone" id="phone" value=""/>
                       
                        </li>
                        <li>
                        <label for="mail">E-post:</label><input type="text" name="mail" id="mail" value=""/>
                       
                        </li>
                        <li>
                        <label for="bDate">Fødselsdato:</label><input type="text" name="bDate" id="bDate" value=""/>
                        <script type="text/javascript">
                   $( "#bDate" ).datepicker({
                    regional:"no",
                    changeMonth: true,
                    changeYear: true,
                    dateFormat:"yy-mm-dd",
                    yearRange:"1940:2012",
                    defaultDate:$("#bDate").val()

                });

            </script>
                       
                        </li>
                        <li>
                        <label for="club">Klubb:</label><input type="text" name="club" id="club" value=""/>
                       
                        </li>
                    </ul>

                </div>
            <div>
                <button class="positiveButton" type="button" onclick="saveNewMember()">Lagre informasjon</button>
                <button class="neutralButton" type="reset" onclick="closeForm()">Avbryt</button>
            
            </div>
        </fieldset>
    </div>
</form>