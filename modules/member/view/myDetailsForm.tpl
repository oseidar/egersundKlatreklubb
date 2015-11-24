<form id="myDetailsForm"
    <div id="formContentWrapper">
        <fieldset >
            <legend ><span class="legendSpan">Rediger bruker:</span></legend>
               
                    <ul class="formUl">
                        <li>
                            <label for="firstName">Fornavn:</label><input type="text" name="firstName" id="firstName" value="[@firstName]"/>
                        </li>
                        <li>
                            <label for="lastName">Etternavn:</label><input type="text" name="lastName" id="lastName" value="[@lastName]"/>
                        </li>
                        <li>
                            <label for="adress">Adresse:</label><input type="text" name="adress" id="adress" value="[@adress]"/>
                        </li>
                        <li>
                        <label for="zip>">Postnr:</label><input type="text" name="zip" id="zip"  value="[@zip]"/>
                       
                        </li>
                  
                         <li>
                        <label for="phone">Telefon:</label><input type="text" name="phone" id="phone" value="[@phone]"/>
                       
                        </li>
                        <li>
                        <label for="mail">E-post:</label><input type="text" name="mail" id="mail" value="[@email]"/>
                       
                        </li>
                        <li>
                        <label for="bDate">Fødselsdato:</label><input type="text" name="bDate" id="bDate" value="[@birthDate]"/>
                       
                        </li>
                        <li>
                        <label for="club">Klubb:</label><input type="text" name="club" id="club" value="[@club]"/>
                       
                        </li>
                    </ul>

            <div>
                <button class="positiveButton" type="button" onclick="saveMyDetails()">Lagre informasjon</button>
                <button class="neutralButton" type="reset" onclick="closeMyDetailsForm()">Avbryt</button>
            
            </div>
        </fieldset>
    </div>
</form>